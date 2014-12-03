/* Sample UDP server */
#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>


int main(int argc, char**argv)
{
   int sockfd,n;
   struct sockaddr_in servaddr,cliaddr;
   socklen_t len;
   char mesg[1000];
   char exitstr[] = "quit";

   sockfd=socket(AF_INET,SOCK_DGRAM,0);

   bzero(&servaddr,sizeof(servaddr));
   servaddr.sin_family = AF_INET;
   servaddr.sin_addr.s_addr=htonl(INADDR_ANY);
   servaddr.sin_port=htons(32000);
   bind(sockfd,(struct sockaddr *)&servaddr,sizeof(servaddr));

 FILE *fout;
 fout=fopen("udpserver_result.txt","a");
 if(fout==NULL) {
   printf("udpserver_result.txt error!!!");
   fclose(fout);
   return;
 }
 
   for (;;)
   {
      len = sizeof(cliaddr);
      n = recvfrom(sockfd,mesg,1000,0,(struct sockaddr *)&cliaddr,&len);
      sendto(sockfd,mesg,n,0,(struct sockaddr *)&cliaddr,sizeof(cliaddr));
      printf("-------------------------------------------------------\n");
      mesg[n] = 0;
      printf("Received the following:\n");
      // 寫到 STDOUT
      printf("%s",mesg);      
      // 寫入檔案
	  //fwrite(mesg , 1 , sizeof(mesg) , fout );
	  fputs(&mesg,fout);
	  fflush(fout);
      printf("-------------------------------------------------------\n");
      if(strcmp("quit\n", mesg) == 0) {
		  fclose(fout);   
		  printf("exit if \n");
		  break;
	  }
   }

}
