<template>
      <v-container fluid class="mx-auto pa-5 blue-grey lighten-4">
    <div class="primary hidden-sm-and-down">
      <h2 style="display:inline" class="ml-2">Программно-технический комплекс</h2>
    </div>
      <v-card class="mx-auto" outlined tile light color="white">
        <v-card-title class="headline font-weight-light">ПТК автоматизации одногорелочных котлов</v-card-title>
        <v-card-subtitle
          class="primary--text font-weight-light"
        >ПТК разработан для автоматизации управления котлоагрегатами серии ДЕ, КВГМ, а также водогрейными и паровыми котлами с аналогичными структурами газораспределения и регулирования и оборудованных одной горелкой.</v-card-subtitle>
        <v-card-text>
          <p>Применение ПТК позволяет:</p>
          <p class="mb-0 primary--text text-uppercase">
            <b>Привести систему газоснабжения котла в полное соответствие с:</b>
          </p>
          <ul>
            <li>ФНП в области промышленной безопасности «Правила безопасности сетей газораспределения и газопотребления»;</li>
            <li>СП 89.13330.2012 «Котельные установки»;</li>  
            <li>СП 62.13330.2011 «Газораспределительные системы».</li>
          </ul>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Повысить экономию топлива при эксплуатации котла на газе</b>
          </p>
          <p
            class="mb-0"
          >Применение надежного автоматического розжига горелки котла уменьшает время розжига котла, что позволяет:</p>
          <ul>
            <li>оперативно гасить или разжигать отдельные котлы при избытке или нехватке тепловой мощности котельной, избегая непроизводительной эксплуатации на малой нагрузке;</li>
            <li>регулировать в оптимальном режиме технологические процессы работы общекотельного оборудования.</li>
          </ul>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Внедрить безопасную технологию розжига котла на газе</b>
          </p>
          <ul>
            <li>проводится автоматическая вентиляция топки, что исключает вероятность заполнения топки газом;</li>
            <li>обеспечивается проверка герметичности газового оборудования перед розжигом;</li>
            <li>гарантируется быстрый и безопасный розжиг горелок с безударным воспламенением на малом расходе газа и воздуха.</li>
          </ul>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Обеспечить эффективное управление мощностью и режимом горения</b>
          </p>
          <p
            class="mb-0"
          >Применение регулирующей заслонки газа перед горелкой и электрофицированных регуляторов воздуха и разрежения позволяет поддерживать оптимальный режим горения и эффективно изменять мощность котла.</p>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Обеспечить безопасность эксплуатации котла при работе на газе в любом режиме управления</b>
          </p>
          <p
            class="mb-0"
          >Исключается неправильная последовательность операций розжига котла при автоматическом и ручном розжиге горелки, за счет применения программируемого управляющего контроллера и встроенной логики защитных блокировок.</p>
          <p
            class="mb-0"
          >В любом режиме управления поддерживается диагностика причины останова горелки при розжиге и работе котла, исключается возможность возникновения аварийной ситуации за счет встроенных алгоритмов автоматического регулирования, предусмотренных требованиями НТД технологических защит и защитных блокировок.</p>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Обеспечить работу котла на резервном топливе (мазуте)</b>
          </p>
          <p
            class="mb-0"
          >Отсечка подачи резервного топлива к котлу обеспечивается защитами по котловым параметрам и параметрам топлива.</p>
          <p class="mb-0">Допускается ручной розжиг:</p>
          <ul>
            <li>резервного топлива на газовый факел при работающей горелке;</li>
            <li>газа на горелке, работающей на резервном топливе.</li>
          </ul>
          <br />
          <p class="mb-0 primary--text text-uppercase">
            <b>Повысить надёжность управления котлом за счёт</b>
          </p>
          <ul>
            <li>внедрения высокотехнологичного газового оборудования;</li>
            <li>централизованной или распределенной системы управления горелкой или котлом, исходя из условий эксплуатации для различных типов котлоагрегатов;</li>
            <li>диагностики состояния всей системы контроля и управления;</li>
          </ul>
        </v-card-text>
      </v-card>
  </v-container>
</template>

<script>
export default {
  name: "home",
  computed: {
  },
  methods: {
  },
  data: () => ({
  })
};
</script>

<style scoped>
p, ul, li {
  font-size: 12pt;
   }
</style>