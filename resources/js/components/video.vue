<template>
    <div class="">
        <div class="flex-video">
        	<video class="img-responsive" height="120px" controls="">
        		<source :src="link" type="video/mp4">
        	</video>
        </div>   
      <div class="caption">
        <p>
            <button
                class="btn btn-info btn-sm"
                @click="getShortLink()"
                >
                    Get link
            </button>

            <button type="button" class="btn btn-danger btn-sm" @click="deleteVideo()">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                </svg>
            </button>

            <span id="le" >
                {{ shortLinkUpadted }}
            </span>
            <button id="copyBtn"
                v-show="le"
                class="btn btn-success btn-sm"
                v-clipboard:copy="shortLinkUpadted"
                v-clipboard:success="onCopy"
                v-clipboard:error="onError"
                >
                    {{ copyStatus }}
            </button>
            
        </p>
      </div>
    </div>
</template>

<script>
	export default{

		props: [
		'link',
        'name'
		],
        data(){
            return{
                shortLink: '',
                le: false,
                copyStatus: 'Copy'
            }
        },
        computed:{
            shortLinkUpadted(){
                return this.shortLink
            }
        },
        methods:{
            getShortLink(){
                
                var data = JSON.stringify({"long_url":process.env.MIX_APP_URL+this.link,"domain":"bit.ly"});
                var config = {
                  method: 'post',
                  url: 'https://api-ssl.bitly.com/v4/shorten',
                  headers: { 
                    'Authorization': 'Bearer '+process.env.MIX_APP_BEARER, 
                    'Content-Type': 'application/json'
                  },
                  data : data
                };

                axios(config).then((response) => {
                  this.shortLink = response.data.link
                  this.le = true
                }).catch((error) => {
                  console.log(error)
                })

            },
            deleteVideo(){
                this.$emit("deleteVideo")
            },
            onCopy(){
                this.copyStatus = "Copied!";
            },
            onError() {
              alert('Failed to copy texts')
            }
        }
	};
</script>

<style scoped>
#le{
    display: none;
}
</style>