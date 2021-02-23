<template>
<div>
    <v-carousel>
          <v-carousel-item
            v-for="(item,i) in items"
            :key="i"
            :src="item.src"
            reverse-transition="fade"
            transition="fade"
          ></v-carousel-item>
        </v-carousel>

        <div class="ma-3">              
          <div class="text-xs-center">               
            <p class="headline">ATMA AUTO</p>
            <p>MOTORCYCLE SPAREPARTS AND SERVICES</p>
            <p>Jl. Babarsari No. 43 Yogyakarta 552181</p>
            <p>Telp. (0274)487711</p>
            <p>http://www.atmaauto.com</p>
          </div>
        </div>                                    
 </div>     
</template>

<script>
export default {
  
  data: () => ({
          
      items: [
        {
          src: 'http://cdn2.tstatic.net/jogja/foto/bank/images/Ban-tubeless.jpg'
        },
        {
          src: 'https://3.bp.blogspot.com/-lEYgg8uzVNE/WC8giS6wVrI/AAAAAAAAI6k/GyhrQ3CK_p04FcYB74TxvaNyrL_lmr_UACK4B/s1600/busi%2Biridium%2Bbosch.jpg'
        },
        {
          src: 'http://rotamec.com/wp-content/uploads/2017/02/motovario-in-line.jpg'
        },
        {
          src: 'http://cdn.elevenia.co.id/g/0/5/5/4/8/7/20055487_B_V1.png'
        }
      ],   
    
  }),
}  

</script>