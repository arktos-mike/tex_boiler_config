<template>
      <viewer
        :images="imgItems"
        @inited="inited"
        @ready.native="play"
        :options="options"
        title="true"
        width=100% height=80%
      >
        <img
          class="image"
          v-for="(imgItem,i) in imgItems"
          :src="imgItem.src"
          :alt="imgItem.descr"
          :key="i"
        />
     </viewer>
    </template>

<script>
export default {
  name: "gallery",
 methods: {
    inited(viewer) {
      this.$viewer = viewer;
    },
    play() {
      this.$viewer.view(0);
      this.$viewer.play();
    }
  },
  data: () => ({
    viewer:null,
    descr: false,
    options: {
      inline: true,
      button: true,
      navbar: 2,
      zoomOnWheel: true
    },
    selectedImage: null,
    imgItems: [
      {
        src: require("@/images/Screens_HMI/00.png"),
        descr: "Панель управления ШАУ. Мнемосхема котла КВГМ-20 ",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_HMI/01.png"),
        descr: "Панель управления ШАУ. Режимная карта",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_HMI/02.png"),
        descr: "Панель управления ШАУ. Графики параметров",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_HMI/03.png"),
        descr: "Панель управления ШАУ. Журнал аварий",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_HMI/14.png"),
        descr: "Панель управления ШАУ. Настройка дискретных сигналов",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_HMI/15.png"),
        descr: "Панель управления ШАУ. Настройка аналоговых сигналов",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_SCADA/00.png"),
        descr: "АРМ оператора. Мнемосхема котла КВГМ-20",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_SCADA/03.png"),
        descr: "АРМ оператора. Журнал событий",
        icon: "mdi-information-outline"
      },
      {
        src: require("@/images/Screens_SCADA/07.png"),
        descr: "АРМ оператора. Графики параметров",
        icon: "mdi-information-outline"
      }
    ]
  })
};
</script>
<style scoped>
.image {
  display: none;
}

</style>