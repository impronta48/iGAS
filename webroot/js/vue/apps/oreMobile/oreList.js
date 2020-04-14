Vue.component("app-ore-list", {
      template: `
                  <div class="mt-5" name="riepilogo" v-if="active">
                        <table class="table table-sm table-striped">
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
                        <b-button pill id="btnNuovo" @click="svuota()" variant="info" size="sm" class="mt-3">Carica nuovo</b-button>
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