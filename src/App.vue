<template>
  <v-app id="landing-page">
    <v-navigation-drawer
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
      v-model="drawer"
      color="#3E545B"
    >
      <!-- <img src="@/assets/logo1.svg" width=100% height=75px alt="ТЭКС-Автоматик" class="hidden-xs-and-down mt-1" style="background-color:#CFD8DC;padding:2%;"/> -->
      <v-list dark>
        <v-list-item-group v-model="menu">
          <v-list-item v-for="item in menuItems" :key="item.title" :to="item.route">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <v-divider></v-divider>
      <v-subheader class="font-weight-light caption float-right" dark>© ЗАО "ГК "ТЭКС-Автоматик"</v-subheader>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="#213039"
      dark
      src="./assets/bar_bg.jpg"
      dense
      hide-on-scroll
      fade-img-on-scroll
      scroll-off-screen
    >
      <template v-slot:img="{ props }">
        <v-img v-bind="props" gradient="to top left, rgba(62, 84, 91,.9), rgba(33, 48, 57,.9)">
          <div class="fill-height bottom-gradient"></div>
        </v-img>
      </template>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <img src="@/assets/logo.svg" alt="ТЭКС-Автоматик" height="40" class="hidden-xs-and-down mt-1" />
      <v-spacer></v-spacer>
      <v-toolbar-title small class="hidden-md-and-down">Комплексная автоматизация котлов</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn class="hidden-md-and-down" href="http://gkta.ru" target="_blank" text>
        <span>ЗАО "ГК "ТЭКС-Автоматик"</span>
        <v-icon>mdi-open-in-new</v-icon>
      </v-btn>
      <template v-slot:extension>
        <v-tabs centered align-with-title show-arrows center-active background-color="transparent">
          <v-tab to="/home">Описание</v-tab>
          <v-tab to="/about">Структура</v-tab>
          <v-tab to="/calc">Конфигуратор</v-tab>
          <v-tab to="/doc">Документация</v-tab>
          <v-tab to="/gallery">Галерея</v-tab>
          <v-tab to="/contacts">Контакты</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-content>
      <!-- <v-container fluid fill-height > -->
      <v-fade-transition mode="out-in">
        <router-view></router-view>
      </v-fade-transition>
      <!-- </v-container> -->
    </v-content>
    <v-fab-transition >
      <v-btn
        class="hidden-sm-and-down"
        dark
        fab small
        bottom
        left
        color="primary"
        fixed
        @click="toTop"
        v-scroll="onScroll"
        v-show="fab"
      >
        <v-icon color="white" large>mdi-chevron-up</v-icon>
      </v-btn>
    </v-fab-transition>
  </v-app>
</template>

<script>
export default {
  name: "App",
  computed: {},
  methods: {
    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.fab = top > 20;
    },
    toTop() {
      this.$vuetify.goTo(0);
    }
  },
  components: {},
  data: () => ({
    drawer: true,
    fab: false,
    menu: 0,
    menuItems: [
      { title: "Описание", icon: "mdi-home-city", route: "/home" },
      { title: "Структура", icon: "mdi-lan", route: "/about" },
      {
        title: "Конфигуратор",
        icon: "mdi-format-list-checks",
        route: "/calc"
      },
      { title: "Документация", icon: "mdi-notebook-outline", route: "/doc" },
      { title: "Галерея", icon: "mdi-camera-outline", route: "/gallery" },
      { title: "Контакты", icon: "mdi-information-outline", route: "/contacts" }
    ]
  })
};
</script>
<style>
#landing-page {
  /* background-image: url('./assets/logo.svg'); */
  background-color: #2e454e;
  height: auto;
  width: auto;
  background-position: center;
  background-repeat: repeat;
  background-size: cover;
  position: relative;
}
html {
  overflow-y: auto !important;
}
body {
  padding: 0px !important;
}
.v-card__text, .v-card__title {
  word-break: normal !important;
}
.viewer-backdrop {
  background-color: #cfd8dc !important;
}
.viewer-player {
  background-color: #cfd8dc !important;
}
.viewer-navbar {
  background-color: #2e454e !important;
}
.bottom-gradient {
  background-image: linear-gradient(
    to top,
    rgba(0, 0, 0, 0.4) 0%,
    transparent 72px
  );
}
.viewer-tooltip {
  font-family: "Noto Sans", sans-serif;
}
.viewer-title {
  color: #e77817 !important;
  background-color: #fff !important;
  padding: 5px !important;
  border-radius: 10px !important;
  font-family: "Noto Sans", sans-serif;
}
</style>