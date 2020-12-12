<template>
    <div class="container">
        <div class="row mt-5 ml-2 mb-3">
            <button class="btn btn-light" @click="triggerUpload()" v-show="!loading">
            Upload video 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cloud-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
              <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
            </svg>
            </button>
            <img class="ml-2" id="spinner" src="assets/img/358.png" alt="" v-show="loading">
            <input type="file" @change="selectFile" id="file" name="file" accept="video/mp4">
        </div>
        <ul class="list-unstyled video-list-thumbs row">
            <li class="col-lg-3 col-sm-4 col-xs-6 d-flex justify-content-center" v-for="(item, index) in linkUpdates">
                <video-component :link="'storage/video/'+item" :name="item" :key="componentKey" @deleteVideo="deleteItem(item)"></video-component>
            </li>
        </ul>
        <div class="row mb-4">
          <div class="col-12 text-center">
            <a href="#" @click="showMore()">Show more...</a>
          </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                video: null,
                description: '',
                productId: 0,
                links: [],
                loading: false,
                componentKey: 0,
                shownVideos: 20
            }
        },
        mounted(){
            axios.get('/video').then((response) => {
              this.links = response.data.data
            }).catch((error) => {
              console.error(error)
            })
        },
        computed: {
            linkUpdates(){
                return this.links
            },
            loadingStatus(){
                return this.loading
            }
        },
        methods: {
            selectFile(event) {
                this.loading = true
                this.video = event.target.files[0];
                const data = new FormData();
                data.append('video', this.video);
                data.append('description', this.description);
                data.append('productId', this.productId);
                axios.post("/video", data).then((response) => {
                      //this.$router.go()
                      this.links = response.data.data
                      this.loading = false
                      this.forceRerender()
                }).catch((error) => {
                  this.loading = false
                  console.error(error);
                }).finally(() => {
                  // TODO
                });

            },
            deleteItem(item){
                this.$swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    axios.post('/video/delete', {
                      videoName: item,
                    }).then((response) => {
                        this.links = response.data.data
                        this.forceRerender()
                    }).catch((error) => {
                      console.error(error);
                    })
                    this.$swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  }
                })
            },
            triggerUpload() {
                document.getElementById('file').click();
            },
            forceRerender(){
                this.componentKey += 1;
            },
            showMore(){
                this.shownVideos = this.shownVideos + 20
                axios.get('/video/'+this.shownVideos).then((response) => {
                    this.links = response.data.data
                }).catch((error) => {
                  console.error(error)
                })
            }
    }
};
</script>

<style scoped>
#file{
    display: none;
}

.video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:12px;
}
.video-list-thumbs > li:last-child{}
.video-list-thumbs > li > video{
  display:block;
  position:relative;
  background-color: #111;
  color: #fff;
  padding: 8px;
  border-radius: 3px;
    transition:all 500ms ease-in-out;
    border-radius:4px;
}
.video-list-thumbs > li > video:hover{
  box-shadow:0 2px 5px rgba(0,0,0,.3);
  text-decoration:none
}
.video-list-thumbs h2{
  bottom: 0;
  font-size: 14px;
  height: 33px;
  margin: 8px 0 0;
}
.video-list-thumbs .glyphicon-play-circle{
    font-size: 60px;
    opacity: 0.6;
    position: absolute;
    right: 39%;
    top: 31%;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
    transition:all 500ms ease-in-out;
}
.video-list-thumbs > li > video:hover .glyphicon-play-circle{
  color:#fff;
  opacity:1;
  text-shadow:0 1px 3px rgba(0,0,0,.8);
}
.video-list-thumbs .duration{
  background-color: rgba(0, 0, 0, 0.4);
  border-radius: 2px;
  color: #fff;
  font-size: 11px;
  font-weight: bold;
  left: 12px;
  line-height: 13px;
  padding: 2px 3px 1px;
  position: absolute;
  top: 12px;
    transition:all 500ms ease;
}
.video-list-thumbs > li > video:hover .duration{
  background-color:#000;
}

#spinner{
    width: 40px;
    height: 40px;
}
</style>
