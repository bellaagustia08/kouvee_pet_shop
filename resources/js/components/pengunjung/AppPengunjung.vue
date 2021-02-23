<template>
    <div id="app">
     <v-app id="inspire">

    <v-navigation-drawer fixed v-model="drawer" app>
    
      <v-list dense>
        <v-list-tile v-for="link in links" :key="link.text" router :to="link.route">
          <v-list-tile-action>            
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{link.text}}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>      
        </v-list>
    </v-navigation-drawer>

    <v-toolbar color="white" app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <img src="../../../../public/Logo.png" alt="" >
      <v-toolbar-title>Kouvee Pet Shop</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-layout row align-center style="max-width: 250px">
        <v-text-field
          placeholder="Search"
          single-line
          append-icon="search"
          :append-icon-cb="() => {}"
          color="white"
          hide-details
        ></v-text-field>
      </v-layout>
    </v-toolbar>
    
    <v-content>
      <v-container >
        <router-view></router-view>
      </v-container>
    </v-content>

        
    <v-footer height="auto" color="indigo">          
              
        <v-flex
        indigo
        py-3
        text-xs-center
        white--text
        xs12
        >
        &copy;2020 — <strong>Kouvee Pet Shop</strong>
        </v-flex>
          
    </v-footer>

</v-app>
</div>
</template>

<script>

export default {
  
  data: () => ({
    
    drawer: null,  
    links: [
      {
        text: 'Home', 
        route: '/',
      },
      {
        text: 'Jasa Service', 
        route: 'jasa-service',
      },
      {
        text: 'Spareparts', 
        route: 'sparepart',
      },
      {
        text: 'History Transaksi', 
        route: 'history',
      },
      {
        text: 'Cari Pengunjung', 
        route: 'pengunjungcari',
      },
      {
        text: 'Contact Us', 
        route: 'contactus',
      },
      
     
    ]
    
  }),
}  


</script>
