<?php
function utf8ize($d)
{
      if (is_array($d)) {
            foreach ($d as $k => $v) {
                  $d[$k] = utf8ize($v);
            }
      } else if (is_string($d)) {
            return utf8_encode($d);
      }
      return $d;
}
?>
<script>
      var $personaId = '<?= $eRisorsa; ?>';
      var $personaName = '<?= $nomePersona; ?>';
      var $eattivita = <?= json_encode(utf8ize($eAttivita)) ?>;
      var $allattivita = <?= json_encode(utf8ize($allAttivita)) ?>;
      var url = '<?= $this->request->base; ?>';
</script>
<style>
      .map {
            height: 300px;
      }

      body {
            background: #6f3200
      }

      #main {
            min-height: 95vh;
            background: #fff;
            border-radius: 0.5rem;
      }

      #header {
            border-bottom: 1px solid #6f3200
      }
</style>
<div class="row" id="ore-app">
      <b-col cols="12" v-if="personaId == ''" class="pt-3">
            A questo utente non è associato un dipendente. Per usare questa funzionalità devi essere un dipendente.
            <a href="<?= $this->Html->url(['controller'=> 'users', 'action'=>'logout']) ?>" class="btn btn-default">Logout</a>
      </b-col>
      <b-col cols="12" class="h-100 my-3 p-2" v-else-if="loading">
            <h2 class="text-secondary text-center"><small>Caricamento Ore</small><br>{{personaName}}</h2>
            <template v-if="!riepilogo">
                  <b-row>
                        <b-col cols="12" class="mt-2">

                              <div class="mt-1" cols="12" v-if="selecAtt!=null"><i class="fas fa-bookmark"></i> attivita: <strong>{{ allattivita[selecAtt] }}</strong></div>
                              <div v-if="dateTimeStart != null">
                                    <i class="fas fa-clock"></i> inizio attivita: <b> {{formatDatedMYhm(dateTimeStart)}}</b>
                              </div>
                              <div v-if="dateTimeStop != null">
                                    <i class="fas fa-stopwatch"></i> fine attivita: <b> {{formatDatedMYhm(dateTimeStop)}}</b>
                              </div>
                              <div v-if="nOre != 0 & nOre!=null">
                                    <i class="fas fa-hourglass-end"></i> numero di ore: <b> {{nOre}}</b>
                              </div>
                              <div v-if="dettagli != null">{{dettagli}}</div>
                              <map-app v-if="locationStart!=null & locationStart!=''" :location-start="locationStart" :location-stop="locationStop"></map-app>
                              <div v-if="mesError!=null" class="alert alert-warning">{{mesError}}</div>
                        </b-col>
                  </b-row>

                  <b-row v-if="selecFase == null">
                        <b-col cols="6">
                              <b-form-input id="input-cerca1" v-model="cerca" class="m-3" placeholder="Cerca..." aria-label="Cerca" class="w-50"></b-form-input>
                        </b-col>
                        <b-col cols="6">
                              <b-button v-if="selecAtt==null" pill id="btnattivita" @click="toggleattivita()" variant="info" size="sm" class="mt-3">Vedi tutte le attivita</b-button>
                        </b-col>
                        <b-col cols="12" v-if="selecAtt==null">
                              <b-card no-body border-variant="light">
                                    <b-card-header>{{titoloAttivita}}</b-card-header>
                                    <b-form-radio-group id="btn-radios-3" v-model="selecAtt" class="border" v-on:change="getFasi" :options="filteredAttvità" value-field="item" text-field="name" button-variant="outline-secondary" buttons stacked name="radio-btn-stacked" class="w-100"></b-form-radio-group>
                              </b-card>
                        </b-col>
                        <b-col cols="12" v-if="selecAtt!=null & selecFase == null">
                              <b-card no-body border-variant="light">
                                    <b-card-header>Fase attivita</b-card-header>
                                    <b-form-radio-group id="btn-radios-3" v-model="selecFase" class="border" value-field="item" text-field="name" :options="filteredFase" button-variant="outline-secondary" buttons stacked name="radio-btn-stacked" class="w-100"></b-form-radio-group>
                              </b-card>
                        </b-col>
                  </b-row>

                  <b-row v-if="dateTimeStart==null & dataCaricamento==null & selecFase != null">
                        <b-col class="mt-3" cols="12">
                              <span class="text-secondary"> data e ora: <b> {{formatDatedMYhm(new Date())}}</b></span>
                              <b-form-textarea class="mt-3" id="textarea" v-model="dettagli" placeholder="Dettagli..." rows="3" max-rows="6"></b-form-textarea>
                        </b-col>
                        <b-col cols="12" class="mt-5 text-center">
                              <b-button pill id="btnStop" @click="setStart()" variant="outline-success" class="border-0 px-0 py-1">
                                    <i class="fas fa-play-circle" style="font-size:8rem"></i>
                              </b-button>
                        </b-col>
                  </b-row>

                  <b-row v-if="dateTimeStart != null  && dateTimeStop==null">
                        <b-col cols="12" class="mt-5 text-center">
                              <b-button pill id="btnStop" @click="setStop()" variant="outline-danger" class="border-0 px-1 py-1">
                                    &nbsp;<i class="far fa-stop-circle" style="font-size:8rem"></i>&nbsp;</b-button>
                        </b-col>
                  </b-row>
            </template>

            <app-ore-list v-if="riepilogo" :persona-id="personaId"></app-ore-list>
      </b-col>
      <b-col v-if="!loading" class="text-center"> Loading... </b-col>

</div>

<?php echo $this->Html->script('vue/apps/oreMobile/oreList', ['inline' => false]); ?>
<?php echo $this->Html->script('vue/apps/oreMobile/app', ['inline' => false]); ?>

<script>
      $(document).ready(function() {
            window.app = {
                  "url": ""
            };
            // addVm.getOra();
      });
</script>