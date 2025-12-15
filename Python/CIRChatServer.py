#!/usr/bin/python3

"""CIR chat server using websockets."""
import asyncio
import websockets
import argparse


def checkArguments():
    """Check program arguments and return program parameters."""
    # Parse options.
    parser = argparse.ArgumentParser()
    parser.add_argument('-i', '--ip', default='localhost',
                        help='websockets server host / ip')
    parser.add_argument('-p', '--port', default=12345,
                        help='websockets server port')
    parser.add_argument('-v', '--verbose', action='store_false',
                        help='verbose mode')
    return parser.parse_args()


async def clientHandler(websocket, _):
    """Client Handler."""
    clients.add(websocket)

    # Wait message until client close connection.
    if args.verbose:
        print(str(websocket.remote_address) + ' open connection')
    while True:
        try:
            message = await websocket.recv()
            if args.verbose:
                print(str(websocket.remote_address) + ' Message received: \"' +
                      message + '\"')
            for client in clients:
                await client.send(message)

        # Connection closed.
        except websockets.ConnectionClosed:
            clients.remove(websocket)
            if args.verbose:
                print(str(websocket.remote_address) + ' close connection')
                break


# Entry point of the program.
clients = set()
args = checkArguments()
if args.ip == 'localhost':
    print('Warning: use real ip instead of localhost for external connections')
server = websockets.serve(clientHandler, args.ip, args.port)
print('WebSockets server launch: ' + args.ip + ':' + str(args.port))
asyncio.get_event_loop().run_until_complete(server)
asyncio.get_event_loop().run_forever()
