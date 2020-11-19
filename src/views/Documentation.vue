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
            <div class="subheading black--text center">{{imgItem.descr}}</div>
          </v-col>
        </v-row>
      </viewer>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "doc",
  data: () => ({
    imgItems: [
      {
        src: require("@/images/Cert/image4.jpeg"),
        descr: "Руководство по эксплуатации"
      },
      {
        src: require("@/images/Cert/image5.jpeg"),
        descr: "Технические условия"
      },
      {
        src: require("@/images/Cert/image6.jpeg"),
        descr: "Паспорт на шкаф ШАУ"
      },
      {
        src: require("@/images/Cert/image7.jpeg"),
        descr: "Паспорт на шкаф ШЭУ"
      },
      {
        src: require("@/images/Cert/image8.jpeg"),
        descr: "Паспорт на шкаф ШУД"
      },
      {
        src: require("@/images/Cert/image4.jpeg"),
        descr: "Сертификат соответствия"
      },
      {
        src: require("@/images/Cert/image5.jpeg"),
        descr: "Технические условия"
      },
      {
        src: require("@/images/Cert/image6.jpeg"),
        descr: "Выписка из реестра СРО"
      },
      {
        src: require("@/images/Cert/image7.jpeg"),
        descr: "Выписка из реестра СРО"
      },
      {
        src: require("@/images/Cert/image8.jpeg"),
        descr: "Выписка из реестра СРО"
      },
      {
        src: require("@/images/Cert/image9.jpeg"),
        descr: "Выписка из реестра СРО"
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