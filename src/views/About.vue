<template>
  <v-card flat>
    <v-tabs v-model="tabs" grow centered center-active background-color="primary">
      <v-tab>
        <v-icon left>mdi-lan</v-icon>ПТК
      </v-tab>
      <v-tab>
        <v-icon left>mdi-car-cruise-control</v-icon>ШАУ
      </v-tab>
      <v-tab>
        <v-icon left>mdi-flash</v-icon>ШЭУ
      </v-tab>
      <v-tab>
        <v-icon left>mdi-fan</v-icon>ШУД
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tabs" touchless>
      <v-tab-item :transition="false" :reverse-transition="false" class="tab1" @click="tabs++">
        <div class="about">
          <div class="scroll-x">
            <img :src="imgItems[0].src" class="img" />
          </div>
        </div>
        <v-card class="mx-auto" outlined tile color="#2e454e" dark>
          <v-card-text class="pa-2 pb-0 text-center">
            <p>
              <strong>ПТК</strong> автоматизации управления котлоагрегатами серии
              <strong>ДЕ</strong>,
              <strong>КВГМ</strong>, а также водогрейными и паровыми котлами с аналогичными структурами газораспределения и регулирования и оборудованных
              <strong>одной</strong> горелкой. ПТК состоит из шкафа автоматики и управления <strong>ШАУ</strong>,	шкафа электропитания и управления <strong>ШЭУ</strong> и шкафов управления двигателем дымососа и вентилятора <strong>ШУД</strong> (опционально).
            </p>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item :transition="false" :reverse-transition="false" class="tab2" @click="tabs++">
        <div class="about">
          <div class="scroll-x">
            <img :src="imgItems[3].src" class="img" />
          </div>
        </div>
        <v-card class="mx-auto" outlined tile color="#192429" dark>
          <v-card-text class="pa-2 pb-0 text-center" >
            <p>
              Шкаф <strong>ШАУ</strong> предназначен для автоматизированного и дистанционного управления с сенсорной панели или АРМ ходом технологического процесса, выполнения запрограммированных алгоритмов автоматического регулирования, технологических защит и блокировок, сбора и обработки данных с аналоговых и дискретных датчиков измерения и контроля параметров технологического процесса, датчиков технологических защит и сигнализатора загазованности.
            </p>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item :transition="false" :reverse-transition="false" class="tab2" @click="tabs++">
        <div class="about">
          <div class="scroll-x">
            <img :src="imgItems[2].src" class="img" />
          </div>
        </div>
        <v-card class="mx-auto" outlined tile color="#192429" dark>
          <v-card-text class="pa-2 pb-0 text-center" >
            <p>
              Шкаф <strong>ШЭУ</strong> предназначен для управления исполнительными устройствами ИМ – электроприводами регуляторов, задвижек, клапанов: заслонки регулирующей газа <strong>ЗРГ</strong>, заслонки регулирующей воды <strong>ЗРВ</strong>, направляющего аппарата вентилятора <strong>НАВ</strong>, направляющего аппарата дымососа <strong>НАД</strong>, задвижки газа <strong>ЗДГ</strong>, задвижки пара <strong>ЗДП</strong>, задвижки питательной воды <strong>ЗДПВ</strong>, задвижки сетевой воды <strong>ЗДСВ</strong>. Шкаф <strong>ШЭУ</strong> также содержит измерители-регуляторы основных параметров управления – нагрузки, давления воздуха, разрежения, уровня в барабане, систему бесперебойного питания для шкафа <strong>ШАУ</strong>.
            </p>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item :transition="false" :reverse-transition="false" class="tab2" @click="tabs++">
        <div class="about">
          <div class="scroll-x">
            <img :src="imgItems[1].src" class="img" />
          </div>
        </div>
        <v-card class="mx-auto" outlined tile color="#192429" dark>
          <v-card-text class="pa-2 pb-0 text-center" >
            <p>
              Шкафы <strong>ШУД</strong> (опционально) предназначены для запуска и управления / защиты дымососа <strong>ДС</strong> и вентилятора <strong>ДВ</strong>, регулирования скорости их вращения установленным в шкафу преобразователем частоты в автоматическом или дистанционном режиме управления. При отсутствии частотного привода и включении вентилятора/дымососа от «сети» предусмотрено регулирование воздействием на электропривод направляющего аппарата дутьевого вентилятора/дымососа <strong>НАВ</strong>, <strong>НАД</strong> через шкаф <strong>ШЭУ</strong>.
            </p>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
export default {
  name: "about",
  data: () => ({
    i: 0,
    tabs: null,
    imgItems: [
      {
        src: require("@/assets/arch.svg")
      },
      {
        src: require("@/assets/arch1.svg")
      },
      {
        src: require("@/assets/arch2.svg")
      },
      {
        src: require("@/assets/arch3.svg")
      }
    ]
  })
};
</script>

<style>
.tab1 {
  background-color: #2e454e;
}
.tab2 {
  background-color: #192429;
}
.scroll-x {
  overflow-x: auto;
  overflow-y: auto;
  height: 100%;
}
.img {
  min-height: 400px;
  max-height: 80vh;
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>