<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.21/vue.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    validate.validators.social_url = function(value, options, key, attributes) {
        if (value.match('/ /')) {
            return 'common invalid'
        }
        return null;
    }

    validate.validators.facebook = function(value, options, key, attributes) {
        if (! value.match(/^https?:\/\/www\.facebook\.com\/.+/)) {
            return 'facebook invalid';
        }
        return null;
    }

    var app = new Vue({
        el: '#socialform',
        data: {
            config: {
                website: {
                    id: 'example',
                    invalid: false,
                    placeholder: 'https://www.example.com',
                    suggestion: '',
                    value: '{{ old('website' , (!empty($team->{'website'})) ? $team->{'website'} : NULL ) }}',
                },
                facebook: {
                    id: 'username',
                    invalid: false,
                    placeholder: 'https://www.facebook.com/username',
                    suggestion: '',
                    value: '{{ old('facebook' , (!empty($team->{'facebook'})) ? $team->{'facebook'} : NULL ) }}',
                },
                twitter: {
                    id: 'username',
                    invalid: false,
                    placeholder: 'https://www.twitter.com/username',
                    suggestion: '',
                    value: '{{ old('twitter' , (!empty($team->{'twitter'})) ? $team->{'twitter'} : NULL ) }}',
                },
                linkedin: {
                    id: 'example-profile',
                    invalid: false,
                    placeholder: 'https://www.linkedin.com/in/example-profile',
                    suggestion: '',
                    value: '{{ old('linkedin' , (!empty($team->{'linkedin'})) ? $team->{'linkedin'} : NULL ) }}',
                },
                instagram: {
                    id: 'username',
                    invalid: false,
                    placeholder: 'https://www.instagram.com/username',
                    suggestion: '',
                    value: '{{ old('instagram' , (!empty($team->{'instagram'})) ? $team->{'instagram'} : NULL ) }}',
                },
                youtube: {
                    id: 'example-channel',
                    invalid: false,
                    placeholder: 'https://www.youtube.com/channel/example-channel',
                    suggestion: '',
                    value: '{{ old('youtube' , (!empty($team->{'youtube'})) ? $team->{'youtube'} : NULL ) }}',
                },
                yelp: {
                    id: 'example-name',
                    invalid: false,
                    placeholder: 'https://www.yelp.com/biz/example-name',
                    suggestion: '',
                    value: '{{ old('yelp' , (!empty($team->{'yelp'})) ? $team->{'yelp'} : NULL ) }}',
                },
            },
        },
        methods: {
            valid_input(type) {
                this.config[type].invalid = false;
                siteregex = new RegExp('^https?:\/\/(www\.)?' + type);
                entered_value = this.config[type].value;
                if (this.config[type].value
                    && (validate({website: this.config[type].value}, {website: {url: true}})
                        || validate({website: this.config[type].value}, {website: {social_url: true}})
                        || (type != 'website'
                            && !this.config[type].value.match(siteregex))
                        || (type == 'facebook'
                                && validate({website: this.config[type].value}, {website: {facebook: true}}))))
                {
                    this.config[type].invalid = true;
                    var suggestion = this.config[type].value;
                    suggestion = suggestion.replace(/[^-a-zA-Z0-9@:%_\+.~#?&\/=]/g, '');

                    // reset to empty if not valid url
                    if (validate({website: this.config[type].value}, {website: {url: true}})) {
                       this.config[type].value = '';
                    }

                    if (type == 'website') {
                        if (!suggestion.match(/^https?:\/\//)) {
                            suggestion = 'https://' + suggestion;
                        }
                        if (!suggestion.match(/\./)) {
                            suggestion += '.com';
                        }
                    }
                    else {
                        // attempt to strip everything except id
                        suggestion = suggestion.replace(/^.*@/, '');
                        suggestion = suggestion.replace(/[^a-zA-Z0-9-_\.]/g, '');
                        suggestion = suggestion.replace(/^.*https?:?\/?\/?/i,'');
                        suggestion = suggestion.replace(/^ww+[/:.-]?/i,'');
                        url_regex = new RegExp('^(.*https?)?:?(\/\/)?(www\.?)?(' + type + ')?(\.com)?\/?', 'i');
                        suggestion = suggestion.replace(url_regex,'');

                        if (suggestion) {
                            match = new RegExp(type + '.com/?');
                            suggestion = suggestion.replace(match, '');
                            id = suggestion;
                            match = new RegExp(this.config[type].id);
                            suggestion = this.config[type].placeholder.replace(match, suggestion);
                        }
                    }
                }
                this.config[type].suggestion_url = suggestion;
                this.config[type].suggestion = '"' + entered_value + '"'
                    + ' looks unusual.<br />';
                if (suggestion) {
                    this.config[type].suggestion += 'Try <a target="_blank" href="' + suggestion + '">' + suggestion + '</a> ?';
                }
            },

            use_suggestion(type) {
                this.config[type].value = this.config[type].suggestion_url;
                this.$refs['input-'+type].focus();
                this.config[type].invalid = false;
            },
        },
    })
</script>