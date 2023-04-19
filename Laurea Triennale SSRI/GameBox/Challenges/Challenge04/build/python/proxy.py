#!/usr/bin/env python3
from http.server import BaseHTTPRequestHandler,HTTPServer
import argparse, os, random, sys, requests
from requests import Request, Session

from socketserver import ThreadingMixIn
import threading

hostname = '10.0.4.3'

def merge_two_dicts(x, y):
    return x | y

def set_header():
    headers = {
        'Host': hostname
    }

    return headers

class ProxyHTTPRequestHandler(BaseHTTPRequestHandler):
    #protocol_version = 'HTTP/1.0'
    def do_HEAD(self):
        self.do_GET(body=False)
        return

    def do_GET(self, body=True):
        sent = False
        try:
            url = 'http://{}{}'.format(hostname, self.path)
            #req_header = self.parse_headers()
            req_headers = {tup[0]: tup[1] for tup in self.headers._headers}
            req_headers["X-Forwarded-For"]=self.client_address[0]
            print ("***Nuova Richiesta***")
            #print(req_headers)
            resp = requests.get(url, headers=merge_two_dicts(req_headers, set_header()),allow_redirects=False)#, verify=False)
            sent = True
            self.send_response(resp.status_code)
            self.send_resp_headers(resp)
            msg = resp.text
            if msg:
                self.wfile.write(msg.encode(encoding='UTF-8',errors='strict'))
            #if self.path=="/flag.html":
                #self.send_error(403, 'not authorized')
            return
        finally:
            if not sent:
                self.send_error(404, 'error trying to proxy')


    def do_POST(self, body=True):       #TE.CL
        sent = False
        if self.path=="/profile.php":
            self.send_error(403, 'not authorized')
        else:
            try:
                url = 'http://{}{}'.format(hostname, self.path)
                post_data=b""
                if "chunked" in self.headers.get("Transfer-Encoding", ""):  #Il body non deve essere toccato dal proxy. Deve essere inoltrato così com'è (al massimo i controlli possono essere fatti ricompattando tutti i chunk)
                    crlf=b"\r\n"
                    #with open(path, "wb") as out_file:
                    while True:
                        line = self.rfile.readline().strip()
                        post_data+=line+crlf
                        chunk_length = int(line, 16)
                        if chunk_length != 0:
                            chunk = self.rfile.read(chunk_length)
                            post_data+=chunk+crlf
                            #out_file.write(chunk)

                        # Each chunk is followed by an additional empty newline
                        # that we have to consume.
                        self.rfile.readline()

                        # Finally, a chunk size of 0 is an end indication
                        if chunk_length == 0:
                            post_data+=crlf
                            break
                elif "Content-Length" in self.headers:
                    content_length = int(self.headers["Content-Length"])
                    body = self.rfile.read(content_length)
                    post_data=body
                #content_len = int(self.headers.get('content-length', 0))
                #post_body = self.rfile.read(content_len)
                req_headers = {tup[0]: tup[1] for tup in self.headers._headers}
                print (req_headers)
                req_headers["X-Forwarded-For"]=self.client_address[0]
                if "Transfer-Encoding" in req_headers and "Content-Length" in req_headers:
                    del req_headers["Transfer-Encoding"] #Altrimenti il server apache considera Transfer-Encoding.
                #if 'Content-Length' in req_headers.items():
                #    del req_headers['Content-Length']
                print ("***Nuova Richiesta***")
                print(req_headers)
                print(repr(post_data.decode("UTF-8")))
                #resp = requests.post(url, data=post_data, headers=merge_two_dicts(req_headers, set_header()),allow_redirects=False)
                s = Session()
                request = requests.Request("POST",url, data=post_data, headers=merge_two_dicts(req_headers, set_header()))#, verify=False)
                prepped = request.prepare()
                if "Content-Length" in req_headers:
                    prepped.headers['Content-Length'] = req_headers["Content-Length"] #IMP: altrimenti requests ricalcola il Content-Length.
                resp = s.send(prepped,allow_redirects=False)
                sent = True

                self.send_response(resp.status_code)
                self.send_resp_headers(resp)
                if resp.content:
                    self.wfile.write(resp.content)
                return
            finally:
                if not sent:
                    self.send_error(404, 'error trying to proxy')

    def parse_headers(self):
        req_header = {}
        for line in self.headers:
            line_parts = [o.strip() for o in line.split(':', 1)]
            if len(line_parts) == 2:
                req_header[line_parts[0]] = line_parts[1]
        return req_header

    def send_resp_headers(self, resp):
        respheaders = resp.headers
        print("***"+str(respheaders)+"***")
        print ('Response Header')
        for key in respheaders:
            if key not in ['Content-Encoding', 'Transfer-Encoding', 'content-encoding', 'transfer-encoding', 'content-length', 'Content-Length']:
                print (key, respheaders[key])
                self.send_header(key, respheaders[key])
        self.send_header('Content-Length', len(resp.content))
        self.end_headers()

def parse_args(argv=sys.argv[1:]):
    parser = argparse.ArgumentParser(description='Proxy HTTP requests')
    parser.add_argument('--port', dest='port', type=int, default=80,
                        help='serve HTTP requests on specified port (default: 80)')
    parser.add_argument('--hostname', dest='hostname', type=str, default='10.0.4.3',
                        help='hostname to be processd (default: 10.0.4.3)')
    args = parser.parse_args(argv)
    return args

class ThreadedHTTPServer(ThreadingMixIn, HTTPServer):
    """Handle requests in a separate thread."""

def main(argv=sys.argv[1:]):
    global hostname
    args = parse_args(argv)
    hostname = args.hostname
    print('http server is starting on {} port {}...'.format(args.hostname, args.port))
    server_address = ('10.0.4.2', args.port)
    httpd = ThreadedHTTPServer(server_address, ProxyHTTPRequestHandler)
    print('http server is running as reverse proxy')
    httpd.serve_forever()

if __name__ == '__main__':
    main()
