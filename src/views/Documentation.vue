<template>
  <v-container fluid class="mx-auto pa-5 blue-grey lighten-4">
    <div class="primary hidden-sm-and-down">
      <h2 style="display:inline" class="ml-2">Документация</h2>
    </div>
    <v-card class="mx-auto" outlined tile light color="white">
      <viewer :images="imgItems" class="px-2">
        <v-row justify="space-around">
          <v-col v-for="(imgItem,i) in imgItems" :key="i" style="text-align: center;">
            <img class="image" :src="imgItem.src" :alt="imgItem.descr" :key="i" />
            <div class="subheading black--text center">{{imgItem.descr}} <v-icon color="primary" @click="popup(imgItem.link,imgItem.descr)" >mdi-pdf-box</v-icon></div>
          </v-col>
        </v-row>
      </viewer>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "doc",
  methods: {
    popup(e,l) {
      //let route = this.$router.resolve({path: e});
      // let route = this.$router.resolve('/link/to/page'); // This also works.
      this.$axios.get(e, { responseType: 'blob' })
      .then(response => {
        const blob = new Blob([response.data], { type: 'application/pdf' })
        const link = document.createElement('a')
        link.href = URL.createObjectURL(blob)
        link.download = l
        link.click()
        URL.revokeObjectURL(link.href)
      }).catch()
    }
  },
  data: () => ({
    imgItems: [
      {
        src: require("@/images/Cert/image1.png"),
        descr: "Выписка из реестра СРО СЧ",
        link: "/docs/doc1.pdf"
      },
      {
        src: require("@/images/Cert/image2.png"),
        descr: "Выписка из реестра СРО СПП",
        link: "/docs/doc2.pdf"
      },
      {
        src: require("@/images/Cert/image3.png"),
        descr: "Сертификат соответствия ИСО",
        link: "/docs/doc3.pdf"
      },
      {
        src: require("@/images/Cert/image4.png"),
        descr: "Сертификат соответствия ТС ШАУ ШЭУ ШУД",
        link: "/docs/doc4.pdf"
      },
      {
        src: require("@/images/Cert/image5.png"),
        descr: "Декларация о соответствии ТС ШАУ ШЭУ ШУД",
        link: "/docs/doc5.pdf"
      },
      {
        src: require("@/images/Cert/image6.png"),
        descr: "Руководство оператора ШАУ КВГМ",
        link: "/docs/doc6.pdf"
      },
      {
        src: require("@/images/Cert/image7.png"),
        descr: "Руководство оператора ШАУ ДЕ",
        link: "/docs/doc7.pdf"
      }
    ]
  })
};
</script>
<style scoped>
.image {
  height: 200px;
  cursor: pointer;
  border: 3px solid #cfd8dc;
  border-radius: 5px;
}
p,
ul,
li {
  font-size: 12pt;
  /* font-family: "Roboto", serif */
}
</style>