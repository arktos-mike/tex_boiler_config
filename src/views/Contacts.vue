<template>
  <v-container fluid class="mx-auto pa-5 blue-grey lighten-4">
    <div class="primary hidden-sm-and-down">
      <h2 class="ml-2">Контакты</h2>
    </div>
    <v-card class="mx-auto" outlined tile light color="white">
      <v-card class="mx-auto pa-2" :ripple="false" tile flat @click.stop="copyAll(); snackbar = true">
        <v-img src="@/assets/logo_full.svg" height="150px" contain></v-img>
        <div class="text-center">
          <p
            class="mt-2"
            style="font-size:120%;"
            @click.stop="copyAll"
          >ЗАО "Группа компаний "ТЭКС-Автоматик"</p>
        </div>
        <v-list two-line>
          <v-list-item @click.stop="copyPhone(); snackbar = true">
            <v-list-item-icon>
              <v-icon color="primary">mdi-phone</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>+7 (8352) 58-57-75</v-list-item-title>
              <v-list-item-subtitle>центральный офис</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>

          <v-list-item @click.stop="copyEmail(); snackbar = true">
            <v-list-item-icon>
              <v-icon color="primary">mdi-email</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>info@gkta.ru</v-list-item-title>
              <v-list-item-subtitle>teks-avt@rambler.ru</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-divider inset></v-divider>

          <v-list-item @click.stop="copyAddr(); snackbar = true">
            <v-list-item-icon>
              <v-icon color="primary">mdi-map-marker</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>
                г.Чебоксары,
                <br />ул.Мичмана Павлова,
                <br class="d-flex d-sm-none" />д.12а
              </v-list-item-title>
              <v-list-item-subtitle>
                428017,
                <br class="d-flex d-sm-none" />Чувашская республика
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
      <v-snackbar v-model="snackbar" :timeout="timeout">
        {{ text }}
        <v-btn color="primary" text @click="snackbar = false">Закрыть</v-btn>
      </v-snackbar>
    </v-card>
    <v-responsive height="330" v-resize="redraw">
      <yandex-map
        @map-was-initialized="init"
        :coords="[56.143404,47.190349]"
        zoom="16"
        style="width: 100%; height: 100%;"
        :controls="['fullscreenControl','typeSelector','zoomControl']"
        map-type="map"
      >
        <ymap-marker
          marker-id="1"
          :icon="{color: 'darkOrange', }"
          marker-type="placemark"
          :coords="[56.143404, 47.190349]"
          hint-content="Группа компаний ТЭКС-Автоматик"
          :balloon="{header: 'Группа компаний ТЭКС-Автоматик', body: 'ул.Мичмана Павлова, д.12а', footer: '2 этаж'}"
        ></ymap-marker>
      </yandex-map>
    </v-responsive>
  </v-container>
</template>

<script>
export default {
  name: "contacts",
  data: () => ({
    map: null,
    snackbar: false,
    text: "",
    timeout: 4000
  }),
  methods: {
    init(map) {
      this.$map = map;
    },
    redraw() {
      if (this.$map != null) {
        this.$map.container.fitToViewport();
      }
    },
    copyPhone() {
      this.$clipboard("+78352585775");
      this.text = "Номер телефона скопирован в буфер обмена";
    },
    copyEmail() {
      this.$clipboard("info@gkta.ru; teks-avt@rambler.ru");
      this.text = "e-mail адреса скопированы в буфер обмена";
    },
    copyAddr() {
      this.$clipboard(
        "428017, Чувашская республика, г.Чебоксары, ул.Мичмана Павлова, д.12а"
      );
      this.text = "Почтовый адрес скопирован в буфер обмена";
    },
    copyAll() {
      this.$clipboard(
        'ЗАО "Группа компаний "ТЭКС-Автоматик" \n +78352585775 \n info@gkta.ru; teks-avt@rambler.ru \n 428017, Чувашская республика, г.Чебоксары, ул.Мичмана Павлова, д.12а'
      );
      this.text = "Контактные данные скопированы в буфер обмена";
    }
  }
};
</script>
