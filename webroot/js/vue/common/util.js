formatMixin = {
	methods: {
		formatDatedMYhm: function(o){
			const d = new Date(o)
			var options = { weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric' , hour : 'numeric', minute: 'numeric'};
			return d.toLocaleDateString("it-IT", options)
		},
		formatDateYMDhm: function(o){
			const d = new Date(o)
			var options = { year: 'numeric', month: 'numeric', day: 'numeric' , hour : 'numeric', minute: 'numeric'};
			return d.toLocaleDateString("en-EN", options)
		},
		formatDateDMY: function(o){
			const d = new Date(o)
			var options = { weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric'};
			return d.toLocaleDateString("it-IT", options)
        },
        formatDateHM: function(o){
			const d = new Date(o)
			var options = { hour : 'numeric', minute: 'numeric'};
			return d.toLocaleDateString("it-IT", options)
        },
       minTommss: function(minutes){
			var sign = minutes < 0 ? "-" : "";
			var min = Math.floor(Math.abs(minutes));
			var sec = Math.floor((Math.abs(minutes) * 60) % 60);
			return sign + (min < 10 ? "0" : "") + min + ":" + (sec < 10 ? "0" : "") + sec;
		     }

	}
}
httpMixin = {
    methods: {
		getNormalizedUrl: function(url) {
			if(url.charAt(0) != '/') {
				// add slash
				url = '/' + url;
			}
			return url;
			},
		httpGet: function (url) {
            return this.$http.get( this.getNormalizedUrl(url) )
            .then(response => {
                return Promise.resolve(response);
            })
            .catch(e => {
                let errorMsg = e.bodyText ? e.bodyText : JSON.stringify(e.body);
                this.$bvToast.toast(errorMsg, {
                    title: e.status + ' - ' + e.statusText,
                    autoHideDelay: 5000,
                    appendToast: true,
                    solid: true,
                    toaster: 'b-toaster-bottom-full',
                    variant: 'danger'
                });
                return Promise.reject(e);
            });
        },
        httpPost: function (url, data) {
            //this.$Progress.start();
            return this.$http.post( this.getNormalizedUrl(url), data )
            .then(response => {
                this.$Progress.finish();
                return Promise.resolve(response);
            })
            .catch(e => {
                this.$Progress.fail();
                let errorMsg = e.bodyText ? e.bodyText : JSON.stringify(e.body);
                this.$bvToast.toast(errorMsg, {
                    title: e.status + ' - ' + e.statusText,
                    autoHideDelay: 5000,
                    appendToast: true,
                    solid: true,
                    toaster: 'b-toaster-bottom-full',
                    variant: 'danger'
                });
                return Promise.reject(e);
            });
        }
    }
};
