<template>
  <v-container fluid class="mx-auto pa-0">
    <v-card class="pa-xl-5 pa-lg-5 pa-md-4 pa-sm-2 pa-xs-0 ma-xs-0 blue-grey lighten-4" tile>
      <v-window v-model="systemType">
        <v-window-item :value="0">
          <v-card class="mx-auto" outlined tile light color="white">
            <v-card-title class="title font-weight-regular">
              <v-icon
                slot="icon"
                color="primary"
                size="36"
                class="hidden-md-and-down px-1"
              >mdi-format-list-checks</v-icon>
              <span
                class="confTitle headline text-center"
              >Программно-технический комплекс для автоматизации одногорелочных котлов</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="pa-5 pb-0">
              <p>
                Данный конфигуратор разработан для
                <strong>ПТК</strong> автоматизации управления котлоагрегатами серии
                <strong>ДЕ</strong>,
                <strong>КВГМ</strong>, а также водогрейными и паровыми котлами с аналогичными структурами газораспределения и регулирования и оборудованных
                <strong>одной</strong> горелкой. ПТК может быть реализован от автоматизации горелки до полномасштабной АСУ ТП котла.
              </p>
              <v-alert outlined color="primary" icon="mdi-help-circle" dense border="left">
                <p class="mb-0">
                  ответьте на несколько вопросов и это поможет выбрать
                  <strong>оптимальный состав</strong> шкафов управления и электропитания, а также рассчитать ориентировочную
                  <strong>стоимость ПТК</strong> в зависимости от поставленных задач автоматизации и финансовых возможностей
                </p>
              </v-alert>
              <h3 class="black--text mb-0">При выборе любого состава ПТК:</h3>
              <ul>
                <li>обеспечивается построение функционально законченных систем управления;</li>
                <li>комплексно решается проблема приведения системы газоснабжения в соответствие с требованиями ФНП в области промышленной безопасности «Правила безопасности сетей газораспределения и газопотребления»;</li>
                <li>система автоматизации остается открытой для дальнейшего расширения и наращивания.</li>
              </ul>
              <v-alert
                class="mt-2"
                outlined
                color="primary"
                icon="mdi-information"
                dense
                border="left"
              >по умолчанию будет предложена минимальная конфигурация оборудования (с учётом резерва каналов)</v-alert>
              <h3 class="black--text">Для продолжения выберите нужный тип котлоагрегата:</h3>
            </v-card-text>
            <v-card-actions class="px-5">
              <v-row>
                <v-col cols="12" md="6" class="pa-auto">
                  <v-btn
                    large
                    tile
                    color="primary"
                    width="100%"
                    depressed
                    @click="systemType = 1; stepMax=11;initCalculate(11,1);"
                  >
                    <v-icon color="white" left size="28">mdi-hand-pointing-right</v-icon>
                    <div class="d-inline">Котел водогрейный КВГМ</div>
                  </v-btn>
                </v-col>
                <v-col cols="12" md="6" class="pa-auto">
                  <v-btn
                    large
                    tile
                    color="primary"
                    width="100%"
                    depressed
                    @click="systemType = 2; stepMax=13;initCalculate(13,2);"
                  >
                    <v-icon color="white" left size="28">mdi-hand-pointing-right</v-icon>
                    <span>Котел паровой ДЕ</span>
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
        </v-window-item>
        <v-window-item :value="1">
          <v-card v-if="systemType===1" class="mx-auto" outlined tile light color="white">
            <v-progress-linear :value="step/stepMax*100" stream buffer-value="0" color="primary"></v-progress-linear>
            <v-stepper class="hidden-xs-only elevation-0" light v-model="step">
              <v-stepper-header>
                <template v-for="n in stepMax">
                  <v-stepper-step
                    :key="`${n}-step`"
                    :complete="step > n"
                    :step="n"
                    editable
                  >Шаг {{ n }}</v-stepper-step>
                  <v-divider v-if="n !== stepMax" :key="n"></v-divider>
                </template>
              </v-stepper-header>
            </v-stepper>
            <v-divider class="hidden-xs-only"></v-divider>
            <v-card-title class="title font-weight-regular justify-space-between">
              <span class="confTitle">{{ currentTitle }}</span>
              <v-spacer></v-spacer>
              <v-chip
                :outlined="step===stepMax?false:true"
                color="primary"
                :text-color="step===stepMax?'white':'primary'"
              >
                <v-avatar left>
                  <v-icon>mdi-checkbox-marked-circle</v-icon>
                </v-avatar>
                <strong>Шаг {{step}}/{{stepMax}}</strong>
              </v-chip>
            </v-card-title>

            <v-window v-model="step">
              <v-window-item class="pa-5" :value="1">
                <h3>Дутьевой вентилятор ДВ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step01_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления вентилятором
                        <strong>ДВ</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="direct">
                    <template v-slot:label>
                      <div>
                        прямой пуск двигателя от
                        <strong>СЕТИ</strong>
                      </div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="inverter">
                    <template v-slot:label>
                      <div>
                        частотное регулирование с помощью преобразователя частоты
                        <strong>ПЧ</strong>
                        <br />(с возможностью прямого пуска)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
                <v-fade-transition>
                  <div class="px-5" v-if="step01_rg01 == `inverter`">
                    <h4>
                      Выберите мощность двигателя вентилятора
                      <strong>ДВ</strong>:
                    </h4>
                    <v-row justify="start" class="mb-4">
                      <v-col cols="12" md="1" class="text-center">
                        <span class="title font-weight-bold" v-text="DV_labels[DV_power-1] + ' '"></span>
                        <span class="subheading font-weight-light mr-1">кВт</span>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-slider
                          v-model="DV_power"
                          :thumb-label="$vuetify.breakpoint.xsOnly? 'always':false"
                          :thumb-size="24"
                          color="primary"
                          track-color="grey"
                          always-dirty
                          step="1"
                          :tick-labels="$vuetify.breakpoint.smAndUp? DV_labels:[]"
                          :ticks="$vuetify.breakpoint.smAndUp? 'always':false"
                          tick-size="2"
                          min="1"
                          :max="DV_labels.length"
                          @change="updateConf(step);configure();calculate();"
                        >
                          <template v-slot:thumb-label>{{DV_labels[DV_power-1]}}</template>
                          <template v-slot:prepend>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DV_power > 1 ? DV_power-- : null;updateConf(step);configure();calculate();"
                            >mdi-minus-circle</v-icon>
                          </template>
                          <template v-slot:append>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DV_power < DV_labels.length ? DV_power++ : null;updateConf(step);configure();calculate();"
                            >mdi-plus-circle</v-icon>
                          </template>
                        </v-slider>
                      </v-col>
                    </v-row>
                  </div>
                </v-fade-transition>
                <div class="px-5">
                  <h4>Добавьте дополнительные возможности расширения (опционально):</h4>
                  <v-checkbox
                    color="primary"
                    v-model="step01_cb01"
                    @change="updateConf(step);configure();calculate();"
                  >
                    <template v-slot:label>
                      <div>диагностика цепей питания и управления</div>
                    </template>
                  </v-checkbox>
                </div>
              </v-window-item>
              <v-window-item class="pa-5" :value="2">
                <h3>Дымосос ДС</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step02_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления дымососом
                        <strong>ДС</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="direct">
                    <template v-slot:label>
                      <div>
                        прямой пуск двигателя от
                        <strong>СЕТИ</strong>
                      </div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="inverter">
                    <template v-slot:label>
                      <div>
                        частотное регулирование с помощью преобразователя частоты
                        <strong>ПЧ</strong>
                        <br />(с возможностью прямого пуска)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
                <v-fade-transition>
                  <div class="px-5" v-if="step02_rg01 == `inverter`">
                    <h4>
                      Выберите мощность двигателя дымососа
                      <strong>ДС</strong>:
                    </h4>
                    <v-row justify="start" class="mb-4">
                      <v-col cols="12" md="1" class="text-center">
                        <span class="title font-weight-bold" v-text="DV_labels[DS_power-1] + ' '"></span>
                        <span class="subheading font-weight-light mr-1">кВт</span>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-slider
                          v-model="DS_power"
                          :thumb-label="$vuetify.breakpoint.xsOnly? 'always':false"
                          :thumb-size="24"
                          color="primary"
                          track-color="grey"
                          always-dirty
                          step="1"
                          :tick-labels="$vuetify.breakpoint.smAndUp? DV_labels:[]"
                          :ticks="$vuetify.breakpoint.smAndUp? 'always':false"
                          tick-size="2"
                          min="1"
                          :max="DV_labels.length"
                          @change="updateConf(step);configure();calculate();"
                        >
                          <template v-slot:thumb-label>{{DV_labels[DS_power-1]}}</template>
                          <template v-slot:prepend>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DS_power > 1 ? DS_power-- : null;;updateConf(step);configure();calculate();"
                            >mdi-minus-circle</v-icon>
                          </template>
                          <template v-slot:append>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DS_power < DV_labels.length ? DS_power++ : null;updateConf(step);configure();calculate();"
                            >mdi-plus-circle</v-icon>
                          </template>
                        </v-slider>
                      </v-col>
                    </v-row>
                  </div>
                </v-fade-transition>
                <div class="px-5">
                  <h4>Добавьте дополнительные возможности расширения (опционально):</h4>
                  <v-checkbox
                    color="primary"
                    v-model="step02_cb01"
                    @change="updateConf(step);configure();calculate();"
                  >
                    <template v-slot:label>
                      <div>диагностика цепей питания и управления</div>
                    </template>
                  </v-checkbox>
                </div>
              </v-window-item>
              <v-window-item class="pa-5" :value="3">
                <h3>Задвижка газа ЗДГ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step03_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДГ</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="4">
                <h3>Задвижка сетевой воды ЗДСВ перед котлом</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step04_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДСВ</strong> перед котлом:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="5">
                <h3>Задвижка сетевой воды ЗДСВ после котла</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step05_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДСВ</strong> после котла:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="6">
                <h3>Контроль загазованности</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step06_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля загазованности:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="dist">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и сигнализация
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="7">
                <h3>Опрессовка газового тракта</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step07_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип опрессовки:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления газа</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step07_rg01 == `discrete`"
                      color="primary"
                      v-model="step07_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком давления газа</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="8">
                <h3>Контроль давления газа перед газовым блоком БГ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step08_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления газа</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step08_rg01 == `discrete`"
                      color="primary"
                      v-model="step08_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком давления газа</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="9">
                <h3>Контроль давления сетевой воды после котла</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step09_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления воды</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step09_rg01 == `discrete`"
                      color="primary"
                      v-model="step09_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком давления воды</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="10">
                <h3>Контроль расхода сетевой воды через котел</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step10_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику расхода воды</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговому датчику
                        <br />(минимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step10_rg01 == `discrete`"
                      color="primary"
                      v-model="step10_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>
                          совместно с пороговым датчиком
                          <br />(максимум)
                        </div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step10_rg01 == `discrete`"
                      color="primary"
                      v-model="step10_cb02"
                      class="ml-7 mt-n4"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком расхода воды</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="11">
                <h3>Отличная конфигурация!</h3>
                <div class="px-5 pt-4">
                  <div class="pb-2">
                    <div>
                      <h4>Выберите дополнительные параметры системы автоматизации:</h4>
                    </div>
                    <v-row no-gutters>
                      <v-col
                        cols="12"
                        md="3"
                        class="mt-1"
                        style="color: rgba(0, 0, 0, 0.54);"
                      >Учет резерва каналов ввода-вывода ПЛК</v-col>
                      <v-col cols="12" md="1">
                        <v-text-field
                          class="font-weight-bold"
                          single-line
                          dense
                          reverse
                          maxlength="5"
                          v-model="resPercent"
                          :rules="[rules.required, rules.counter]"
                          prefix="%"
                          @change="inputValue($event);configure();calculate();"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-checkbox color="primary" v-model="zip" @change="configure();calculate();">
                      <template v-slot:label>
                        <div>Запасные части, инструменты и принадлежности ЗИП</div>
                      </template>
                    </v-checkbox>
                    <v-checkbox
                      color="primary"
                      v-model="ups"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>Источник бесперебойного питания ИБП</div>
                      </template>
                    </v-checkbox>
                  </div>
                  <div class="pb-8">
                    <h3>
                      Итоговая стоимость:
                      <strong>{{totalSum.toString(10).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')}}</strong> ₽ (с НДС)
                    </h3>
                  </div>
                  <div class="pb-2">
                    <strong>Выбранные опции:</strong>
                  </div>
                  <v-list-item-group v-model="item1" multiple color="primary">
                    <v-list-item v-for="(item1, i) in options" :key="i">
                      <v-list-item-content>{{item1.descr}}</v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </div>
                <div class="px-5 pt-4">
                  <strong>Мы можем отправить эту информацию Вам на электронную почту:</strong>
                  <v-form ref="form" v-model="valid">
                    <v-row>
                      <v-col cols="auto">
                        <v-text-field
                          v-model="name"
                          :rules="[rules.required]"
                          label="Ваше имя"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="auto">
                        <v-text-field
                          v-model="email"
                          :rules="[rules.required, rules.email]"
                          label="Ваш e-mail"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="auto">
                        <v-btn
                          tile
                          depressed
                          :disabled="!valid"
                          color="primary"
                          class="mr-4"
                          @click="sendEmail();"
                        >Отправить</v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </div>
              </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
              <v-btn tile outlined text @click="step===1?systemType = 0:step--">НАЗАД</v-btn>
              <v-spacer></v-spacer>
              <div class="d-inline">
                <div class="d-none d-sm-inline pe-1">Итого:</div>
                <strong class="primary--text" style="font-size: 130%;">
                  <ICountUp
                    style="font-family: Roboto;"
                    :decimals="0"
                    :duration="100"
                    :endVal="totalSum"
                    :options="c_options"
                  />
                </strong>
                <div class="d-inline pe-1" style="font-size: 130%;">₽</div>
                <div class="d-none d-sm-inline">(с НДС)</div>
              </div>
              <v-spacer></v-spacer>
              <v-btn
                tile
                :disabled="step === stepMax"
                color="primary"
                depressed
                @click="step++"
              >ДАЛЕЕ</v-btn>
            </v-card-actions>
          </v-card>
        </v-window-item>
        <v-window-item :value="2">
          <v-card v-if="systemType===2" class="mx-auto" outlined tile light color="white">
            <v-progress-linear :value="step/stepMax*100" stream buffer-value="0" color="primary"></v-progress-linear>
            <v-stepper class="hidden-xs-only elevation-0" light v-model="step">
              <v-stepper-header>
                <template v-for="n in stepMax">
                  <v-stepper-step
                    :key="`${n}-step`"
                    :complete="step > n"
                    :step="n"
                    editable
                  >Шаг {{ n }}</v-stepper-step>
                  <v-divider v-if="n !== stepMax" :key="n"></v-divider>
                </template>
              </v-stepper-header>
            </v-stepper>
            <v-divider class="hidden-xs-only"></v-divider>
            <v-card-title class="title font-weight-regular justify-space-between">
              <span class="confTitle">{{ currentTitle }}</span>
              <v-spacer></v-spacer>
              <v-chip
                :outlined="step===stepMax?false:true"
                color="primary"
                :text-color="step===stepMax?'white':'primary'"
              >
                <v-avatar left>
                  <v-icon>mdi-checkbox-marked-circle</v-icon>
                </v-avatar>
                <strong>Шаг {{step}}/{{stepMax}}</strong>
              </v-chip>
            </v-card-title>
            <v-window v-model="step">
              <v-window-item class="pa-5" :value="1">
                <h3>Дутьевой вентилятор ДВ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step101_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления вентилятором
                        <strong>ДВ</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="direct">
                    <template v-slot:label>
                      <div>
                        прямой пуск двигателя от
                        <strong>СЕТИ</strong>
                      </div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="inverter">
                    <template v-slot:label>
                      <div>
                        частотное регулирование с помощью преобразователя частоты
                        <strong>ПЧ</strong>
                        <br />(с возможностью прямого пуска)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
                <v-fade-transition>
                  <div class="px-5" v-if="step101_rg01 == `inverter`">
                    <h4>
                      Выберите мощность двигателя вентилятора
                      <strong>ДВ</strong>:
                    </h4>
                    <v-row justify="start" class="mb-4">
                      <v-col cols="12" md="1" class="text-center">
                        <span class="title font-weight-bold" v-text="DV_labels[DV_power2-1] + ' '"></span>
                        <span class="subheading font-weight-light mr-1">кВт</span>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-slider
                          v-model="DV_power2"
                          :thumb-label="$vuetify.breakpoint.xsOnly? 'always':false"
                          :thumb-size="24"
                          color="primary"
                          track-color="grey"
                          always-dirty
                          step="1"
                          :tick-labels="$vuetify.breakpoint.smAndUp? DV_labels:[]"
                          :ticks="$vuetify.breakpoint.smAndUp? 'always':false"
                          tick-size="2"
                          min="1"
                          :max="DV_labels.length"
                          @change="updateConf(step);configure();calculate();"
                        >
                          <template v-slot:thumb-label>{{DV_labels[DV_power2-1]}}</template>
                          <template v-slot:prepend>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DV_power2 > 1 ? DV_power2-- : null;updateConf(step);configure();calculate();"
                            >mdi-minus-circle</v-icon>
                          </template>
                          <template v-slot:append>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DV_power2 < DV_labels.length ? DV_power2++ : null;updateConf(step);configure();calculate();"
                            >mdi-plus-circle</v-icon>
                          </template>
                        </v-slider>
                      </v-col>
                    </v-row>
                  </div>
                </v-fade-transition>
                <div class="px-5">
                  <h4>Добавьте дополнительные возможности расширения (опционально):</h4>
                  <v-checkbox
                    color="primary"
                    v-model="step101_cb01"
                    @change="updateConf(step);configure();calculate();"
                  >
                    <template v-slot:label>
                      <div>диагностика цепей питания и управления</div>
                    </template>
                  </v-checkbox>
                </div>
              </v-window-item>
              <v-window-item class="pa-5" :value="2">
                <h3>Дымосос ДС</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step102_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления дымососом
                        <strong>ДС</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="direct">
                    <template v-slot:label>
                      <div>
                        прямой пуск двигателя от
                        <strong>СЕТИ</strong>
                      </div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="inverter">
                    <template v-slot:label>
                      <div>
                        частотное регулирование с помощью преобразователя частоты
                        <strong>ПЧ</strong>
                        <br />(с возможностью прямого пуска)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
                <v-fade-transition>
                  <div class="px-5" v-if="step102_rg01 == `inverter`">
                    <h4>
                      Выберите мощность двигателя дымососа
                      <strong>ДС</strong>:
                    </h4>
                    <v-row justify="start" class="mb-4">
                      <v-col cols="12" md="1" class="text-center">
                        <span class="title font-weight-bold" v-text="DV_labels[DS_power2-1] + ' '"></span>
                        <span class="subheading font-weight-light mr-1">кВт</span>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-slider
                          v-model="DS_power2"
                          :thumb-label="$vuetify.breakpoint.xsOnly? 'always':false"
                          :thumb-size="24"
                          color="primary"
                          track-color="grey"
                          always-dirty
                          step="1"
                          :tick-labels="$vuetify.breakpoint.smAndUp? DV_labels:[]"
                          :ticks="$vuetify.breakpoint.smAndUp? 'always':false"
                          tick-size="2"
                          min="1"
                          :max="DV_labels.length"
                          @change="updateConf(step);configure();calculate();"
                        >
                          <template v-slot:thumb-label>{{DV_labels[DS_power2-1]}}</template>
                          <template v-slot:prepend>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DS_power2 > 1 ? DS_power2-- : null;;updateConf(step);configure();calculate();"
                            >mdi-minus-circle</v-icon>
                          </template>
                          <template v-slot:append>
                            <v-icon
                              size="32"
                              color="primary"
                              @click="DS_power2 < DV_labels.length ? DS_power2++ : null;updateConf(step);configure();calculate();"
                            >mdi-plus-circle</v-icon>
                          </template>
                        </v-slider>
                      </v-col>
                    </v-row>
                  </div>
                </v-fade-transition>
                <div class="px-5">
                  <h4>Добавьте дополнительные возможности расширения (опционально):</h4>
                  <v-checkbox
                    color="primary"
                    v-model="step102_cb01"
                    @change="updateConf(step);configure();calculate();"
                  >
                    <template v-slot:label>
                      <div>диагностика цепей питания и управления</div>
                    </template>
                  </v-checkbox>
                </div>
              </v-window-item>
              <v-window-item class="pa-5" :value="3">
                <h3>Задвижка газа ЗДГ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step103_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДГ</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="4">
                <h3>Задвижка питательной воды ЗДПВ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step104_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДПВ</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="5">
                <h3>Задвижка пара ЗДП</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step105_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>
                        Выберите тип управления задвижкой
                        <strong>ЗДП</strong>:
                      </h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="drive">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и управление
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="6">
                <h3>Контроль загазованности</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step106_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля загазованности:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="dist">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль и сигнализация
                        <br />(с заведением в систему управления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="7">
                <h3>Опрессовка газового тракта</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step107_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип опрессовки:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления газа</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step107_rg01 == `discrete`"
                      color="primary"
                      v-model="step107_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком давления газа</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="8">
                <h3>Контроль давления газа перед газовым блоком БГ</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step108_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления газа</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                  <v-fade-transition>
                    <v-checkbox
                      v-if="step108_rg01 == `discrete`"
                      color="primary"
                      v-model="step108_cb01"
                      class="ml-7 mt-n1"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>совместно с датчиком давления газа</div>
                      </template>
                    </v-checkbox>
                  </v-fade-transition>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="9">
                <h3>Контроль давления пара в барабане котла</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step109_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику давления пара</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговому датчику
                        <br />(максимум)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="10">
                <h3>Контроль уровня воды в барабане котла</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step110_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по датчику уровня воды</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>
                        по пороговым датчикам
                        <br />(минимум и максимум)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="11">
                <h3>Контроль расхода питательной воды</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step111_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="none">
                    <template v-slot:label>
                      <div>без контроля</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="analog">
                    <template v-slot:label>
                      <div>по расходомеру с аналоговым выходом</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="discrete">
                    <template v-slot:label>
                      <div>по импульсному выходу счетчика воды</div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="12">
                <h3>Контроль параметров пара в магистрали</h3>
                <v-radio-group
                  class="px-5"
                  v-model="step112_rg01"
                  :mandatory="false"
                  @change="updateConf(step);configure();calculate();"
                >
                  <template v-slot:label>
                    <div>
                      <h4>Выберите тип контроля:</h4>
                    </div>
                  </template>
                  <v-radio color="primary" value="local">
                    <template v-slot:label>
                      <div>местный (без заведения в систему управления)</div>
                    </template>
                  </v-radio>
                  <v-radio color="primary" value="dist">
                    <template v-slot:label>
                      <div>
                        дистанционный контроль (с заведением в систему управления
                        <br />расходомера пара, датчиков температуры и давления)
                      </div>
                    </template>
                  </v-radio>
                </v-radio-group>
              </v-window-item>
              <v-window-item class="pa-5" :value="13">
                <h3>Отличная конфигурация!</h3>
                <div class="px-5 pt-4">
                  <div class="pb-2">
                    <div>
                      <h4>Выберите дополнительные параметры системы автоматизации:</h4>
                    </div>
                    <v-row no-gutters>
                      <v-col
                        cols="12"
                        md="3"
                        class="mt-1"
                        style="color: rgba(0, 0, 0, 0.54);"
                      >Учет резерва каналов ввода-вывода ПЛК</v-col>
                      <v-col cols="12" md="1">
                        <v-text-field
                          class="font-weight-bold"
                          single-line
                          dense
                          reverse
                          maxlength="5"
                          v-model="resPercent"
                          :rules="[rules.required, rules.counter]"
                          prefix="%"
                          @change="inputValue($event);configure();calculate();"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-checkbox color="primary" v-model="zip" @change="configure();calculate();">
                      <template v-slot:label>
                        <div>Запасные части, инструменты и принадлежности ЗИП</div>
                      </template>
                    </v-checkbox>
                    <v-checkbox
                      color="primary"
                      v-model="ups"
                      @change="updateConf(step);configure();calculate();"
                    >
                      <template v-slot:label>
                        <div>Источник бесперебойного питания ИБП</div>
                      </template>
                    </v-checkbox>
                  </div>
                  <div class="pb-8">
                    <h3>
                      Итоговая стоимость:
                      <strong>{{totalSum.toString(10).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')}}</strong> ₽ (с НДС)
                    </h3>
                  </div>
                  <div class="pb-2">
                    <strong>Выбранные опции:</strong>
                  </div>
                  <v-list-item-group v-model="item1" multiple color="primary">
                    <v-list-item v-for="(item1, i) in options" :key="i">
                      <v-list-item-content>{{item1.descr}}</v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </div>
                <div class="px-5 pt-4">
                  <strong>Мы можем отправить эту информацию Вам на электронную почту:</strong>
                  <v-form ref="form" v-model="valid">
                    <v-row>
                      <v-col cols="auto">
                        <v-text-field
                          v-model="name"
                          :rules="[rules.required]"
                          label="Ваше имя"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="auto">
                        <v-text-field
                          v-model="email"
                          :rules="[rules.required, rules.email]"
                          label="Ваш e-mail"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col cols="auto">
                        <v-btn
                          tile
                          depressed
                          :disabled="!valid"
                          color="primary"
                          class="mr-4"
                          @click="sendEmail();"
                        >Отправить</v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </div>
              </v-window-item>
            </v-window>
            <v-divider></v-divider>

            <v-card-actions>
              <v-btn tile outlined text @click="step===1?systemType = 0:step--">НАЗАД</v-btn>
              <v-spacer></v-spacer>
              <div class="d-inline">
                <div class="d-none d-sm-inline pe-1">Итого:</div>
                <strong class="primary--text" style="font-size: 130%;">
                  <ICountUp
                    style="font-family: Roboto;"
                    :decimals="0"
                    :duration="100"
                    :endVal="totalSum"
                    :options="c_options"
                  />
                </strong>
                <div class="d-inline pe-1" style="font-size: 130%;">₽</div>
                <div class="d-none d-sm-inline">(с НДС)</div>
              </div>
              <v-spacer></v-spacer>
              <v-btn
                tile
                :disabled="step === stepMax"
                color="primary"
                depressed
                @click="step++"
              >ДАЛЕЕ</v-btn>
            </v-card-actions>
          </v-card>
        </v-window-item>
      </v-window>
    </v-card>
    <v-snackbar v-model="snackbar" :timeout="timeout">
      {{text}}
      <v-btn color="primary" text @click="snackbar = false">Закрыть</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
const queryString = require("query-string");
import ICountUp from "vue-countup-v2";
export default {
  components: {
    ICountUp
  },
  data: () => {
    return {
      rules: {
        required: value => !!value || "обязательно",
        counter: value => (value >= 0 && value <= 100) || "от 0 до 100%",
        email: value => {
          if (typeof value !== "undefined") {
            if (value.length > 0) {
              const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              return pattern.test(value) || "неверный e-mail";
            } else return true;
          } else return true;
        }
      },
      email: "",
      name: "",
      valid: true,
      snackbar: false,
      text: "",
      timeout: 4000,
      c_options: {
        useEasing: true,
        useGrouping: true,
        separator: " ",
        decimal: ",",
        prefix: "",
        suffix: " "
      },
      DV_power: 1,
      DV_power2: 1,
      DV_labels: [5.5, 7.5, 11, 15, 18.5, 22, 30, 37, 45, 55, 75, 90],
      DS_power: 1,
      DS_power2: 1,
      ZD_count: 0,
      systemType: 0,
      displayAll: true,
      item1: {},
      item2: {},
      step: 1,
      stepMax: 0,
      zip: false,
      ups: false,
      initConf: { di: 0, do: 0, ai: 0, ao: 0 },
      totalConf: { di: 0, do: 0, ai: 0, ao: 0 },
      totalMod: { di: 0, do: 0, ai: 0, ao: 0 },
      totalCalc: { hardware: 0, software: 0, works: 0 },
      resPercent: 10,
      gktaPercent: 0.05,
      step01_cb01: false,
      step01_rg01: "direct",
      step02_cb01: false,
      step02_rg01: "direct",
      step03_rg01: "local",
      step04_rg01: "local",
      step05_rg01: "local",
      step06_rg01: "local",
      step07_cb01: false,
      step07_rg01: "discrete",
      step08_cb01: false,
      step08_rg01: "discrete",
      step09_cb01: false,
      step09_rg01: "discrete",
      step10_cb01: false,
      step10_cb02: false,
      step10_rg01: "discrete",
      step101_cb01: false,
      step101_rg01: "direct",
      step102_cb01: false,
      step102_rg01: "direct",
      step103_rg01: "local",
      step104_rg01: "local",
      step105_rg01: "local",
      step106_rg01: "local",
      step107_cb01: false,
      step107_rg01: "discrete",
      step108_cb01: false,
      step108_rg01: "discrete",
      step109_rg01: "discrete",
      step110_rg01: "discrete",
      step111_rg01: "none",
      step112_rg01: "local",
      price_db: [],
      channel_db: [],
      diArr: [],
      doArr: [],
      aiArr: [],
      aoArr: [],
      invArr: []
    };
  },
  mounted() {
    this.$axios.get("/data.json").then(response => {
      this.channel_db = response.data.channel_db;
      this.price_db = response.data.price_db;
      this.diArr = response.data.diArr;
      this.doArr = response.data.doArr;
      this.aiArr = response.data.aiArr;
      this.aoArr = response.data.aoArr;
      this.invArr = response.data.invArr;
    });
  },
  computed: {
    currentTitle() {
      switch (this.systemType) {
        case 1:
          return "Конфигуратор ПТК автоматизации котла КВГМ";
        case 2:
          return "Конфигуратор ПТК автоматизации котла ДЕ";
        default:
          return "";
      }
    },
    config() {
      var config = [];
      for (var i = 0; i < this.price_db.length; i++) {
        for (var k = 0; k < this.price_db[i].selectedOption.length; k++) {
          if (
            this.price_db[i].selectedOption[k].pcs > 0 &&
            (this.price_db[i].display || this.displayAll)
          )
            config.push(this.price_db[i].selectedOption[k]);
        }
      }
      return config;
    },
    options() {
      var options = [];
      this.channel_db[this.systemType - 1].selectedOptions.forEach(element => {
        options.push(element);
      });
      this.channel_db.forEach(element => {
        if (
          !element.title.includes("minimal") &&
          element.selectedOption.descr != null
        ) {
          options.push(element.selectedOption);
        }
      });
      return options;
    },
    totalSum() {
      return (
        Math.ceil(
          Math.ceil(
            (this.totalCalc.hardware +
              this.totalCalc.software +
              this.totalCalc.works) *
              1.2
          ) / 1000
        ) * 1000
      );
    }
  },
  methods: {
    inputValue(value) {
      if (value >= 0 && value <= 100) {
        this.resPercent = value;
        this.updateConf();
      }
    },
    sendEmail() {
      var html = "";
      html =
        `<div style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><strong>Итого: </strong><strong>` +
        this.totalSum
          .toString(10)
          .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 ") +
        `</strong> ₽ (с НДС)</div>` +
        `<div id="adm" style="font-size: 16px; font-weight: normal; margin-top: -20px; margin-bottom: 20px;"> (<strong>` +
        Math.ceil(this.totalCalc.hardware)
          .toString(10)
          .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 ") +
        `</strong> ₽ за оборудование, <strong>` +
        Math.ceil(this.totalCalc.software)
          .toString(10)
          .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 ") +
        `</strong> ₽ за разработку, <strong>` +
        Math.ceil(this.totalCalc.works)
          .toString(10)
          .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 ") +
        `</strong> ₽ за монтажные работы)</div>` +
        `<div id="adm" style="font-size: 16px; font-weight: normal; margin-top: -20px; margin-bottom: 20px;"><strong>Количество каналов: </strong><strong>` +
        this.totalConf.di +
        `</strong> дискр. вх., <strong>` +
        this.totalConf.do +
        `</strong> дискр. вых., <strong>` +
        this.totalConf.ai +
        `</strong> аналог. вх., <strong>` +
        this.totalConf.ao +
        `</strong> аналог. вых. (<strong>` +
        this.totalMod.di +
        `</strong> дискр. вх., <strong>` +
        this.totalMod.do +
        `</strong> дискр. вых., <strong>` +
        this.totalMod.ai +
        `</strong> аналог. вх., <strong>` +
        this.totalMod.ao +
        `</strong> аналог. вых. по модулям)</div>` +
        `<div style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><strong>Выбранные опции:</strong><ul style="font-size: 16px; font-weight: normal;">`;
      this.options.forEach(function(item) {
        html += "<li>" + item.descr + "</li>";
      });
      html += `</ul></div><div id="adm" style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><strong>Состав основных компонентов шкафов автоматики:</strong><ul style="font-size: 16px; font-weight: normal;">`;
      this.config.forEach(function(item) {
        html += "<li>" + item.descr + ` - ` + item.pcs + `шт.` + "</li>";
      });
      html += `</ul></div>`;

      var ups;
      if (this.ups) {
        ups = ", a также источник бесперебойного питания";
      } else {
        ups = "";
      }

      var zip;
      if (this.zip) {
        zip = " и комплект ЗИП.";
      } else {
        zip = ".";
      }

      if (this.$refs.form.validate()) {
        this.$axios.post(
          "/sendmail.php",
          queryString.stringify({
            name: this.name,
            email: this.email,
            multiText:
              `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width" /><style>body {width: 100% !important;height: 100% !important;background: #efefef !important;-webkit-font-smoothing: antialiased !important;-webkit-text-size-adjust: none !important;}</style></head><body style="width: 100% !important; height: 100% !important; -webkit-font-smoothing: antialiased !important; -webkit-text-size-adjust: none !important;" bgcolor="#efefef"><table style="width: 100% !important; height: 100% !important; -webkit-font-smoothing: antialiased !important; -webkit-text-size-adjust: none !important;" bgcolor="#efefef"><tr><td style="display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto;"><table style="width: 100% !important; border-collapse: collapse;"><tr><td align="center" style="color: white; padding: 20px 0;" bgcolor="#e77817"><h2 style="line-height: 1.25; font-size: 28px;">ПТК автоматизации котлов </h2></td></tr><tr><td style="padding: 30px 35px;" bgcolor="white"><h3 style="color: #e77817; margin-bottom: 20px; line-height: 1.25; font-size: 24px;">Здравствуйте, ` +
              this.name +
              `!</h3><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;">Благодарим за то, что Вы воспользовались нашим сервисом и сформировали конфигурацию программно-технического комплекса (ПТК) автоматизации котлов.</p><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;">Напомним состав и стоимость сконфигурированной системы:</p><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;">` +
              html +
              `</p><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;">` +
              "Также в Вашем заказе учтен резерв " +
              this.resPercent +
              "% каналов" +
              ups +
              zip +
              `</p><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><strong>Внимание!</strong> Данный расчёт является предварительным, чтобы продолжить реализацию данной системы автоматизации сообщите нам:</p><table style="width: 100% !important; border-collapse: collapse;"><tr><td align="center"><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><a href="mailto:info@gkta.ru?subject=ПТК автоматизации котлов" style="color: white !important; text-decoration: none; display: inline-block !important; background-color: #e77817 !important; font-weight: bold !important; border-radius: 4px !important; border-color: #e77817; border-style: solid; border-width: 10px 20px 8px;">свяжитесь с нами</a></p></td></tr></table><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;">Кстати, если Вы хотите более подробно изучить возможности системы автоматизации котлов, почитать документацию, посмотреть сертификаты или рассчитать состав и стоимость ПТК, посетите <a href="https://config.gkta.ru" style="color: #e77817; text-decoration: none;">сайт продукта</a>.</p><p style="font-size: 16px; font-weight: normal; margin-bottom: 20px;"><em>– конфигуратор ПТК автоматизации котлов ТЭКС-Автоматик</em></p></td></tr></table></td></tr><tr style="max-width: 580px !important;"><td style="display: block !important; clear: both !important; max-width: 580px !important; margin: 0 auto; padding: 30px 35px;" bgcolor="white"><p style="font-size: 14px; font-weight: normal; margin-bottom: 0; color: #888;" align="center">Отправлено <a href="http://gkta.ru" style="color: #888; text-decoration: none; font-weight: bold;">ЗАО "ГК "ТЭКС-Автоматик"</a>, 428017, Чувашская республика, г.Чебоксары, ул.Мичмана Павлова, д.12а</p><p style="font-size: 14px; font-weight: normal; margin-bottom: 0; color: #888;" align="center"><a href="mailto:info@gkta.ru" style="color: #888; text-decoration: none; font-weight: bold;">info@gkta.ru</a></p></td></tr></table></body></html>`
          })
        );
      }
      this.text = "Письмо на адрес " + this.email + " было отправлено";
      this.snackbar = true;
      this.$refs.form.reset();
      this.valid = false;
    },
    configure() {
      //
      // расчет модулей
      //
      var baseunits = 0;
      var di_ch = 0;
      var do_ch = 0;
      var ai_ch = 0;
      var ao_ch = 0;
      var index = this.price_db.findIndex(item => item.title === "plc_io_di");
      this.price_db[index].selectedOption = this.ioConf(
        this.totalConf.di,
        this.price_db[index].options,
        this.zip
      );
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          if (this.zip) {
            baseunits += element.pcs - 1;
            di_ch += element.ch * (element.pcs - 1);
          } else {
            baseunits += element.pcs;
            di_ch += element.ch * element.pcs;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "plc_io_do");
      this.price_db[index].selectedOption = this.ioConf(
        this.totalConf.do,
        this.price_db[index].options,
        this.zip
      );
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          if (this.zip) {
            baseunits += element.pcs - 1;
            do_ch += element.ch * (element.pcs - 1);
          } else {
            baseunits += element.pcs;
            do_ch += element.ch * element.pcs;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "plc_io_ai");
      this.price_db[index].selectedOption = this.ioConf(
        this.totalConf.ai,
        this.price_db[index].options,
        this.zip
      );
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          if (this.zip) {
            baseunits += element.pcs - 1;
            ai_ch += element.ch * (element.pcs - 1);
          } else {
            baseunits += element.pcs;
            ai_ch += element.ch * element.pcs;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "plc_io_ao");
      this.price_db[index].selectedOption = this.ioConf(
        this.totalConf.ao,
        this.price_db[index].options,
        this.zip
      );
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          if (this.zip) {
            baseunits += element.pcs - 1;
            ao_ch += element.ch * (element.pcs - 1);
          } else {
            baseunits += element.pcs;
            ao_ch += element.ch * element.pcs;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "plc_baseunit");
      this.price_db[index].selectedOption = this.price_db[index].options;
      this.price_db[index].selectedOption[
        this.price_db[index].selectedOption.findIndex(
          item => item.title === "BU_15"
        )
      ].pcs = baseunits;
      //
      // расчет БП
      //
      index = this.price_db.findIndex(item => item.title === "ps");
      this.price_db[index].selectedOption = this.psConf(
        di_ch,
        do_ch,
        ai_ch,
        ao_ch,
        this.price_db[index].options,
        this.zip
      );
      this.totalMod.di = di_ch;
      this.totalMod.do = do_ch;
      this.totalMod.ai = ai_ch;
      this.totalMod.ao = ao_ch;
      //
      // расчет обвязки модулей + обвязки ШУД и ШЭУ
      //
      this.modConfClear(this.diArr);
      this.modConfClear(this.doArr);
      this.modConfClear(this.aiArr);
      this.modConfClear(this.aoArr);
      this.modConf(this.diArr, di_ch);
      this.modConf(this.doArr, do_ch);
      this.modConf(this.aiArr, ai_ch);
      this.modConf(this.aoArr, ao_ch);
      index = this.price_db.findIndex(item => item.title === "relay");
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          element.pcs = element.pcs + 6;
          if (this.zip) {
            element.pcs = element.pcs + 2;
          }
          if (
            this.step01_rg01 == "inverter" ||
            this.step101_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 2;
          }
          if (
            this.step02_rg01 == "inverter" ||
            this.step102_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 2;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "fix");
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          element.pcs = element.pcs + 47;
          if (
            this.step01_rg01 == "inverter" ||
            this.step101_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 6;
          }
          if (
            this.step02_rg01 == "inverter" ||
            this.step102_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 6;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "terminal");
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          element.pcs = element.pcs + 235;
          if (
            this.step01_rg01 == "inverter" ||
            this.step101_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 23;
          }
          if (
            this.step02_rg01 == "inverter" ||
            this.step102_rg01 == "inverter"
          ) {
            element.pcs = element.pcs + 23;
          }
        }
      });
      index = this.price_db.findIndex(item => item.title === "fuse");
      this.price_db[index].selectedOption.forEach(element => {
        if (element.pcs > 0) {
          if (this.zip) {
            element.pcs = element.pcs + 1;
          }
        }
      });
      //
      // расчет ПЛК
      //
      index = this.price_db.findIndex(item => item.title === "plc_cpu");
      this.price_db[index].selectedOption = [];
      var index_item = this.price_db[index].options.findIndex(
        item => item.title === "S_1510SP"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "S_RJ"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "S_FLASH"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      //
      // расчет прочего оборудования
      //
      index = this.price_db.findIndex(item => item.title === "switcher");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_XB5"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 0;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 2;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 2;
      }
      //
      index = this.price_db.findIndex(item => item.title === "switcher_aux");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_ZBE"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 3;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 6;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 6;
      }
      //
      index = this.price_db.findIndex(item => item.title === "switcher_cam");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_K2"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      //
      index = this.price_db.findIndex(item => item.title === "control_relay");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_RM17"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      //
      index = this.price_db.findIndex(item => item.title === "distr_box");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_LGY125"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 2;
      //
      index = this.price_db.findIndex(item => item.title === "distr_box");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "SE_LGY100"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 0;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      //
      index = this.price_db.findIndex(item => item.title === "hmi");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "W_3103"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      //
      index = this.price_db.findIndex(item => item.title === "cab");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "DKC"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 2;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      //
      index = this.price_db.findIndex(item => item.title === "indicator");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "EL_IRT"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      switch (this.systemType) {
        case 1:
          this.price_db[index].selectedOption[0].pcs = 1;
          break;
        case 2:
          this.price_db[index].selectedOption[0].pcs = 2;
          break;
        default:
          break;
      }
      //
      index = this.price_db.findIndex(item => item.title === "control_manual");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "ABS_BRU"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      switch (this.systemType) {
        case 1:
          this.price_db[index].selectedOption[0].pcs = 3;
          break;
        case 2:
          this.price_db[index].selectedOption[0].pcs = 4;
          break;
        default:
          break;
      }
      //
      index = this.price_db.findIndex(item => item.title === "ups");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "EATON_9SX"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.ups ? 1 : 0;
      //
      index = this.price_db.findIndex(item => item.title === "starter");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "ABS_PBR"
      );
      this.price_db[index].selectedOption = [];
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      switch (this.systemType) {
        case 1:
          this.price_db[index].selectedOption[0].pcs = 3;
          break;
        case 2:
          this.price_db[index].selectedOption[0].pcs = 4;
          break;
        default:
          break;
      }
      //
      index = this.price_db.findIndex(item => item.title === "cab_int");
      this.price_db[index].selectedOption = [];

      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Lamp_XB7"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 9 : 6;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 5;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 5;
      }
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Button_XB5"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 3;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 2;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 2;
      }
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Button_AS"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Socket_220"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Cover_MA1"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Sound_alarm"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Thermo_NO"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 2;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_6"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 16 : 15;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 3;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 3;
      }
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_10"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 3 : 2;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_25"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 2 : 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_16"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 2 : 1;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_3"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.zip ? 3 : 2;
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Switch_aux"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 12;
      //
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "Spare"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 2;
      if (this.step01_rg01 == "inverter" || this.step101_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      if (this.step02_rg01 == "inverter" || this.step102_rg01 == "inverter") {
        this.price_db[index].selectedOption[0].pcs += 1;
      }
      //
      // расчёт обвязки ДВ и ДС
      //
      var pwr;
      this.invConfClear(this.invArr);
      if (this.step01_rg01 == "inverter") {
        pwr = parseFloat(this.DV_labels[this.DV_power - 1]);
        this.invConf(this.invArr, pwr, this.step01_cb01);
      }
      if (this.step02_rg01 == "inverter") {
        pwr = parseFloat(this.DV_labels[this.DS_power - 1]);
        this.invConf(this.invArr, pwr, this.step02_cb01);
      }
      if (this.step101_rg01 == "inverter") {
        pwr = parseFloat(this.DV_labels[this.DV_power2 - 1]);
        this.invConf(this.invArr, pwr, this.step101_cb01);
      }
      if (this.step102_rg01 == "inverter") {
        pwr = parseFloat(this.DV_labels[this.DS_power2 - 1]);
        this.invConf(this.invArr, pwr, this.step102_cb01);
      }
      //
      // расчёт обвязки задвижек
      //
      this.ZD_count = 0;
      if (this.step03_rg01 == "drive" || this.step103_rg01 == "drive") {
        index = this.price_db.findIndex(item => item.title === "switch");
        index_item = this.price_db[index].options.findIndex(
          item => item.title === "A_1_6"
        );
        this.price_db[index].selectedOption.unshift(
          this.price_db[index].options[index_item]
        );
        this.price_db[index].selectedOption[0].pcs = 1;
        this.ZD_count++;
      }
      //
      index = this.price_db.findIndex(item => item.title === "switch");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "A_4"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = 0;
      if (this.step04_rg01 == "drive" || this.step104_rg01 == "drive") {
        this.price_db[index].selectedOption[0].pcs += 1;
        this.ZD_count++;
      }
      if (this.step05_rg01 == "drive" || this.step105_rg01 == "drive") {
        this.price_db[index].selectedOption[0].pcs += 1;
        this.ZD_count++;
      }
      //
      index = this.price_db.findIndex(item => item.title === "switch_aux");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "A_AUX-C2Q"
      );
      if (
        this.step01_rg01 == "inverter" ||
        this.step02_rg01 == "inverter" ||
        this.step101_rg01 == "inverter" ||
        this.step102_rg01 == "inverter"
      ) {
        this.price_db[index].selectedOption[0].pcs += this.ZD_count;
      } else {
        this.price_db[index].selectedOption.unshift(
          this.price_db[index].options[index_item]
        );
        this.price_db[index].selectedOption[0].pcs = this.ZD_count;
      }
      //
      index = this.price_db.findIndex(item => item.title === "contactor");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "A_9"
      );
      this.price_db[index].selectedOption.unshift(
        this.price_db[index].options[index_item]
      );
      this.price_db[index].selectedOption[0].pcs = this.ZD_count * 2;
      //
      index = this.price_db.findIndex(item => item.title === "contactor_aux");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "A_CA4_10"
      );
      if (
        this.step01_rg01 == "inverter" ||
        this.step02_rg01 == "inverter" ||
        this.step101_rg01 == "inverter" ||
        this.step102_rg01 == "inverter"
      ) {
        this.price_db[index].selectedOption[0].pcs += this.ZD_count * 4;
      } else {
        this.price_db[index].selectedOption.unshift(
          this.price_db[index].options[index_item]
        );
        this.price_db[index].selectedOption[0].pcs = this.ZD_count * 4;
      }
      //
      index = this.price_db.findIndex(item => item.title === "reverseBlock");
      index_item = this.price_db[index].options.findIndex(
        item => item.title === "A_VM4"
      );
      if (typeof this.price_db[index].selectedOption[0] === "undefined") {
        this.price_db[index].selectedOption.unshift(
          this.price_db[index].options[index_item]
        );
        this.price_db[index].selectedOption[0].pcs = this.ZD_count;
      } else if (
        this.price_db[index].selectedOption.some(
          elem => elem.title === this.price_db[index].options[index_item].title
        )
      ) {
        this.price_db[index].selectedOption[
          this.price_db[index].selectedOption.findIndex(
            item =>
              item.title === this.price_db[index].options[index_item].title
          )
        ].pcs += this.ZD_count;
      } else {
        this.price_db[index].selectedOption.unshift(
          this.price_db[index].options[index_item]
        );
        this.price_db[index].selectedOption[0].pcs = this.ZD_count;
      }
    },
    calculate() {
      //
      // расчет стоимости конфигурации
      //
      this.totalCalc.hardware = 0;
      for (var i = 0; i < this.price_db.length; i++) {
        for (var k = 0; k < this.price_db[i].selectedOption.length; k++) {
          if (this.price_db[i].selectedOption[k].pcs > 0)
            this.totalCalc.hardware +=
              this.price_db[i].selectedOption[k].price *
              this.price_db[i].selectedOption[k].pcs;
        }
      }
      this.totalCalc.hardware += this.totalCalc.hardware * this.gktaPercent;
      var yk, yb;
      yk = (100000 - 150000) / (80 - 140);
      yb = 150000 - 140 * yk;
      this.totalCalc.software =
        (this.totalMod.di +
          this.totalMod.do +
          this.totalMod.ai +
          this.totalMod.ao) *
          yk +
        yb;
      yk = (100000 - 140000) / (80 - 140);
      yb = 140000 - 140 * yk;
      this.totalCalc.works =
        (this.totalMod.di +
          this.totalMod.do +
          this.totalMod.ai +
          this.totalMod.ao) *
          yk +
        yb;
      if (this.step01_rg01 == "inverter") {
        yk = (70000 - 100000) / (1 - 12);
        yb = 100000 - 12 * yk;
        this.totalCalc.works += this.DV_power * yk + yb;
      }
      if (this.step02_rg01 == "inverter") {
        yk = (70000 - 100000) / (1 - 12);
        yb = 100000 - 12 * yk;
        this.totalCalc.works += this.DS_power * yk + yb;
      }
      if (this.step101_rg01 == "inverter") {
        yk = (70000 - 100000) / (1 - 12);
        yb = 100000 - 12 * yk;
        this.totalCalc.works += this.DV_power2 * yk + yb;
      }
      if (this.step102_rg01 == "inverter") {
        yk = (70000 - 100000) / (1 - 12);
        yb = 100000 - 12 * yk;
        this.totalCalc.works += this.DS_power2 * yk + yb;
      }
      yk = (80000 - 110000) / (0 - 3);
      yb = 110000 - 3 * yk;
      this.totalCalc.works += this.ZD_count * yk + yb;
    },
    modConfClear(arr) {
      arr.forEach(element => {
        var index = this.price_db.findIndex(item => item.title === element.cat);
        var index_item = this.price_db[index].options.findIndex(
          item => item.title === element.item
        );
        this.price_db[index].selectedOption = [];
        this.price_db[index].options[index_item].pcs = 0;
      });
    },
    modConf(arr, ch) {
      arr.forEach(element => {
        var index = this.price_db.findIndex(item => item.title === element.cat);
        var index_item = this.price_db[index].options.findIndex(
          item => item.title === element.item
        );
        if (typeof this.price_db[index].selectedOption[0] === "undefined") {
          this.price_db[index].selectedOption.unshift(
            this.price_db[index].options[index_item]
          );
          this.price_db[index].selectedOption[0].pcs = element.qty * ch;
        } else if (
          this.price_db[index].selectedOption.some(
            elem => elem.title === element.item
          )
        ) {
          this.price_db[index].selectedOption[
            this.price_db[index].selectedOption.findIndex(
              item => item.title === element.item
            )
          ].pcs += element.qty * ch;
        } else {
          this.price_db[index].selectedOption.unshift(
            this.price_db[index].options[index_item]
          );
          this.price_db[index].selectedOption[0].pcs = element.qty * ch;
        }
      });
    },
    psConf(di_ch, do_ch, ai_ch, ao_ch, types, zip) {
      var output = [];
      types.forEach(element => {
        if (element.pcs > 0) element.pcs = 0;
      });
      output = types;
      for (var i = 0; i < types.length; i++) {
        if (
          types[i].cur > (di_ch * 0.05 + do_ch * 0.01) * 0.8 &&
          di_ch !== 0 &&
          do_ch !== 0
        ) {
          output[i].pcs++;
          break;
        }
      }
      for (var j = 0; j < types.length; j++) {
        if (
          types[j].cur > (ai_ch * 0.08 + ao_ch * 0.08) * 1 &&
          ai_ch !== 0 &&
          ao_ch !== 0
        ) {
          output[j].pcs++;
          break;
        }
      }
      output[0].pcs += 2;

      if (zip)
        output.forEach(element => {
          if (element.pcs > 0) element.pcs++;
        });

      return output;
    },
    invConfClear(arr) {
      arr.forEach(element => {
        var index = this.price_db.findIndex(item => item.title === element.cat);
        this.price_db[index].selectedOption = [];
        this.price_db[index].options.forEach(e => {
          e.pcs = 0;
        });
      });
    },
    invConf(arr, pwr, add) {
      var corr = false;
      var cur =
        (pwr * 1000) /
        (Math.sqrt(3) *
          (pwr > 7.5 ? 0.9 : 0.85) *
          (pwr > 7.5 ? 0.85 : 0.8) *
          380);
      arr.forEach(element => {
        var index = this.price_db.findIndex(item => item.title === element.cat);
        switch (element.cat) {
          case "inverter":
            var index_item = this.price_db[index].options.findIndex(
              item => item.title.includes(element.pref + "_") && item.pwr >= pwr
            );
            break;
          case "contactor":
            index_item = this.price_db[index].options.findIndex(
              item => item.title.includes(element.pref + "_") && item.cur >= cur
            );
            break;
          case "contactor_aux":
            index_item = this.price_db[index].options.findIndex(item =>
              item.title.includes(element.pref + "_")
            );
            break;
          case "switch":
            index_item = this.price_db[index].options.findIndex(
              item => item.title.includes(element.pref + "_") && item.cur >= cur
            );
            break;
          case "switch_aux":
            index_item = this.price_db[index].options.findIndex(item =>
              item.title.includes(element.pref + "_")
            );
            if (!add) {
              corr = true;
            }
            break;
          case "circuitBreaker":
            index_item = this.price_db[index].options.findIndex(
              item => item.title.includes(element.pref + "_") && item.cur > cur
            );
            break;
          case "circuitBreaker_aux":
            index_item = this.price_db[index].options.findIndex(item =>
              item.title.includes(element.pref + "_")
            );
            if (!add) {
              corr = true;
            }
            break;
          case "reverseBlock":
            index_item = this.price_db[index].options.findIndex(
              item => item.title.includes(element.pref + "_") && item.cur > cur
            );
            break;
          default:
            break;
        }
        if (typeof this.price_db[index].selectedOption[0] === "undefined") {
          this.price_db[index].selectedOption.unshift(
            this.price_db[index].options[index_item]
          );
          this.price_db[index].selectedOption[0].pcs = corr
            ? element.qty - 1
            : element.qty;
        } else if (
          this.price_db[index].selectedOption.some(
            elem =>
              elem.title === this.price_db[index].options[index_item].title
          )
        ) {
          this.price_db[index].selectedOption[
            this.price_db[index].selectedOption.findIndex(
              item =>
                item.title === this.price_db[index].options[index_item].title
            )
          ].pcs += corr ? element.qty - 1 : element.qty;
        } else {
          this.price_db[index].selectedOption.unshift(
            this.price_db[index].options[index_item]
          );
          this.price_db[index].selectedOption[0].pcs = corr
            ? element.qty - 1
            : element.qty;
        }
        corr = false;
      });
    },
    ioConf(channels, types, zip) {
      var output = [];
      types.forEach(element => {
        if (element.pcs > 0) element.pcs = 0;
      });
      var k = channels;
      output = types;
      for (var i = 0; i < types.length; i++) {
        if (i === types.length - 1) {
          output[i].pcs = Math.ceil(k / types[i].ch);
        } else {
          if (k % types[i].ch <= types[types.length - 1].ch) {
            output[i].pcs = Math.floor(k / types[i].ch);
          } else {
            output[i].pcs = Math.ceil(k / types[i].ch);
          }
        }
        k = k - output[i].pcs * types[i].ch;
        if (k < 0) {
          k = 0;
        }
        if (zip && output[i].pcs > 0) {
          output[i].pcs++;
        }
      }
      return output;
    },
    updateConf(step) {
      var index;
      var option;
      switch (this.systemType) {
        case 1:
          switch (step) {
            case 1:
              index = this.channel_db.findIndex(
                item => item.title == "optionDV"
              );
              option = this.step01_rg01 == "direct" ? "direct" : "inverter";
              option = this.step01_cb01 ? option + "_add" : option;
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 2:
              index = this.channel_db.findIndex(
                item => item.title == "optionDS"
              );
              option = this.step02_rg01 == "direct" ? "direct" : "inverter";
              option = this.step02_cb01 ? option + "_add" : option;
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 3:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDG"
              );
              option = this.step03_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 4:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDSV_before"
              );
              option = this.step04_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 5:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDSV_after"
              );
              option = this.step05_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 6:
              index = this.channel_db.findIndex(
                item => item.title == "optionGas_detect"
              );
              option = this.step06_rg01 == "dist" ? "dist" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 7:
              index = this.channel_db.findIndex(
                item => item.title == "optionPressure"
              );
              option =
                this.step07_rg01 == "discrete"
                  ? this.step07_cb01
                    ? "discrete_add"
                    : "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 8:
              index = this.channel_db.findIndex(
                item => item.title == "optionGasBlock"
              );
              option =
                this.step08_rg01 == "discrete"
                  ? this.step08_cb01
                    ? "discrete_add"
                    : "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 9:
              index = this.channel_db.findIndex(
                item => item.title == "optionWater"
              );
              option =
                this.step09_rg01 == "discrete"
                  ? this.step09_cb01
                    ? "discrete_add"
                    : "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 10:
              index = this.channel_db.findIndex(
                item => item.title == "optionFlow"
              );
              option =
                this.step10_rg01 == "discrete"
                  ? this.step10_cb01
                    ? "discrete_max"
                    : "discrete"
                  : "analog";
              if (this.step10_rg01 == "discrete") {
                option = this.step10_cb02 ? option + "_add" : option;
              }
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            default:
          }
          break;
        case 2:
          switch (step) {
            case 1:
              index = this.channel_db.findIndex(
                item => item.title == "optionDV"
              );
              option = this.step101_rg01 == "direct" ? "direct" : "inverter";
              option = this.step101_cb01 ? option + "_add" : option;
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 2:
              index = this.channel_db.findIndex(
                item => item.title == "optionDS"
              );
              option = this.step102_rg01 == "direct" ? "direct" : "inverter";
              option = this.step102_cb01 ? option + "_add" : option;
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 3:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDG"
              );
              option = this.step103_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 4:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDPV"
              );
              option = this.step104_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 5:
              index = this.channel_db.findIndex(
                item => item.title == "optionZDP"
              );
              option = this.step105_rg01 == "drive" ? "drive" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 6:
              index = this.channel_db.findIndex(
                item => item.title == "optionGas_detect"
              );
              option = this.step106_rg01 == "dist" ? "dist" : "local";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 7:
              index = this.channel_db.findIndex(
                item => item.title == "optionPressure"
              );
              option =
                this.step107_rg01 == "discrete"
                  ? this.step107_cb01
                    ? "discrete_add"
                    : "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 8:
              index = this.channel_db.findIndex(
                item => item.title == "optionGasBlock"
              );
              option =
                this.step108_rg01 == "discrete"
                  ? this.step108_cb01
                    ? "discrete_add"
                    : "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 9:
              index = this.channel_db.findIndex(
                item => item.title == "optionDrumPressure"
              );
              option = this.step109_rg01 == "discrete" ? "discrete" : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 10:
              index = this.channel_db.findIndex(
                item => item.title == "optionDrumLevel"
              );
              option = this.step110_rg01 == "discrete" ? "discrete" : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 11:
              index = this.channel_db.findIndex(
                item => item.title == "optionFlow2"
              );
              option =
                this.step111_rg01 == "none"
                  ? "none"
                  : this.step111_rg01 == "discrete"
                  ? "discrete"
                  : "analog";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;
            case 12:
              index = this.channel_db.findIndex(
                item => item.title == "optionSteam"
              );
              option = this.step112_rg01 == "local" ? "local" : "dist";
              this.channel_db[index].selectedOption = this.channel_db[
                index
              ].options[
                this.channel_db[index].options.findIndex(
                  item => item.title == option
                )
              ];
              break;

            default:
          }
          break;
        default:
      }
      for (
        var i = 2,
          length = this.channel_db.length,
          optDi = 0,
          optDo = 0,
          optAi = 0,
          optAo = 0;
        i < length;
        i++
      ) {
        if (typeof this.channel_db[i].selectedOption.di !== "undefined") {
          optDi += this.channel_db[i].selectedOption.di;
          optDo += this.channel_db[i].selectedOption.do;
          optAi += this.channel_db[i].selectedOption.ai;
          optAo += this.channel_db[i].selectedOption.ao;
        }
      }
      this.totalConf.di =
        this.initConf.di +
        optDi +
        Math.ceil(((this.initConf.di + optDi) * this.resPercent) / 100);
      if (this.ups) {
        this.totalConf.di += 2;
      }
      this.totalConf.do =
        this.initConf.do +
        optDo +
        Math.ceil(((this.initConf.do + optDo) * this.resPercent) / 100);
      this.totalConf.ai =
        this.initConf.ai +
        optAi +
        Math.ceil(((this.initConf.ai + optAi) * this.resPercent) / 100);
      this.totalConf.ao =
        this.initConf.ao +
        optAo +
        Math.ceil(((this.initConf.ao + optAo) * this.resPercent) / 100);
    },
    initCalculate(stepMax, systemType) {
      this.initConf.di = 0;
      this.initConf.do = 0;
      this.initConf.ai = 0;
      this.initConf.ao = 0;
      this.channel_db[systemType - 1].selectedOptions.forEach(element => {
        this.initConf.di += element.di;
        this.initConf.do += element.do;
        this.initConf.ai += element.ai;
        this.initConf.ao += element.ao;
      });
      this.channel_db.forEach(element => {
        if (!element.title.includes("minimal")) {
          element.selectedOption = [];
        }
      });
      for (var i = 1; i <= stepMax; i++) {
        this.updateConf(i);
      }
      this.configure();
      this.calculate();
    }
  }
};
</script>

<style lang="scss" scoped>
p,
ul,
li,
span,
button,
div {
  font-family: "Noto Sans", sans-serif;
}
p,
ul,
li {
  font-size: 12pt;
}
h4 {
  color: rgba(0, 0, 0, 0.54);
}
.confTitle {
  color: #e77817;
}
.confBadge {
  font-size: 50%;
}
</style>
