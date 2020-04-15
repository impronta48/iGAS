Vue.component("app-ore-list", {
      template: `
                  <div class="mt-3 text-center" name="riepilogo" v-if="active">
                        <b-button pill id="btnNuovo" @click="svuota()" variant="info" size="md" class="my-3">Inizia nuova attività</b-button>
                        <table class="table table-sm table-striped text-left">
                              <thead>
                                    <tr>
                                          <th scope="col">Data e ora</th>
                                          <th scope="col">Ore</th>
                                          <th scope="col">attivita</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr v-for="dati in riepilogo">
                                          <td>{{formatDateHM(dati.Ora.start)}}</td>
                                          <td>{{dati.Ora.numOre}}</td>
                                          <td>{{allattivita[dati.Ora.eAttivita]}} - {{dati.Faseattivita.Descrizione}}</td>
                                    </tr>
                              </tbody>
                        </table>
                  </div>
		`,
      props: ['personaId'],
      mixins: [formatMixin],
      data: function () {
            return {
                  riepilogo: [],
                  allattivita: $allattivita,
            };
      },
      watch: {},
      computed: {
            active: {
                  get: function () {
                        return axios.post('/ore/getOrebyPersona/' + this.personaId + '.json', {})
                              .then(res => {
                                    if (res.data.length > 0) {
                                          this.riepilogo = res.data;
                                    }
                              });
                  return true;
                  },
                  set: function (e) {},
            },

      },
      events: {},
      methods: {
            svuota() {
                  window.location.reload(true)
            },

      }
});