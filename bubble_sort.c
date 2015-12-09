#include <stdio.h>
#include <sys/time.h>

double time_diff(struct timeval x , struct timeval y);
 
int main()
{
  int n=12,tt;
  int c, d, swap;
  int array[12]={3,4,1,3,5,1,92,2,4124,424,52,12};

    int i;
     
    struct timeval before , after;
    gettimeofday(&before , NULL);
  

for (tt=0;tt<900000;tt++) {

  for (c = 0 ; c < ( n - 1 ); c++)
  {
    for (d = 0 ; d < n - c - 1; d++)
    {
      if (array[d] > array[d+1]) /* For decreasing order use < */
      {
        swap       = array[d];
        array[d]   = array[d+1];
        array[d+1] = swap;
      }
    }
  }

}
 


  printf("Sorted list in ascending order:\n"); 
  for ( c = 0 ; c < n ; c++ )
     printf("%d ", array[c]);


    gettimeofday(&after , NULL);
    printf("Total time elapsed : %.0lf us" , time_diff(before , after) );
 
  return 0;
}

 
double time_diff(struct timeval x , struct timeval y)
{
    double x_ms , y_ms , diff;
     
    x_ms = (double)x.tv_sec*1000000 + (double)x.tv_usec;
    y_ms = (double)y.tv_sec*1000000 + (double)y.tv_usec;
     
    diff = (double)y_ms - (double)x_ms;
     
    return diff;
}



