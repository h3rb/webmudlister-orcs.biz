/*
 * Hostcheck
 * by H. Elwood Gilliland III
 *
 * Checks to see if a host is valid.
 */
#include <sys/unistd.h>
#include <ctype.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main( int argc, char **argv )
{
    int out_socket;
    struct sockaddr_in remote_server;
    struct hostent *hp;
    char buf[1024];

/*
 * Attempts to resolve said host.
 */
    if ( argv[1][0] == '\0' ) {
        puts( "Usage:  hostcheck <hostname> <port>\n\n" );
        exit( 1 );
    }

    out_socket = socket(AF_INET, SOCK_STREAM, 0 );
    remote_server.sin_family = AF_INET;

    hp = gethostbyname(argv[1]);
    if ( hp == NULL ) {
        fputs( "BADHOST", stdout );
        exit( 1 );
    }

    remote_server.sin_port = htons(atoi(argv[2]));
    bcopy( hp->h_addr, &remote_server, hp->h_length);

    if ( connect( out_socket, (struct sockaddr*)&remote_server, 
	  	  sizeof(remote_server)) >= 0 ) {

    close( out_socket );
    }

    fputs( "HOSTOK", stdout );
    exit( 0 );
}

