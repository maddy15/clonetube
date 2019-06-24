<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div class="alert alert-danger" v-if="failed">
                            Uploading Failed
                        </div>

                        <div id="video-form" v-if="uploading && !failed">

                            <div class="alert alert-info" v-if="!uploadingComplete">
                                
                                Your video will be available at <a :href="$root.url + ':8000/video/' + uid" target="_blank">{{ $root.url }}/video/{{ uid }}</a>.
                            </div>

                            <div class="alert alert-success" v-if="uploadingComplete">
                                Upload Complete.Video is now processing.
                                <a href="/videos">Go to your videos</a>
                                </div>

                            <div class="progress" v-if="!uploadingComplete">
                                <div class="progress-bar" role="progressbar" :style="{ width: fileProgress + '%'}" :aria-valuenow="fileProgress" aria-valuemin="0" aria-valuemax="100">{{ fileProgress + '%'}}</div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <span class="help-block float-right">{{ saveStatus }}</span>
                            <button class="btn btn-light" type="submit" @click.prevent="update">Save Changes</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                uid : null,
                uploading: false,
                uploadingComplete : false,
                failed : false,
                title : 'Untitled',
                description : null,
                visibility : 'private',
                saveStatus : null,
                errors : {},
                fileProgress : 0
            }
        },
       methods: {
           fileInputChange() {
               this.uploading = true;
               this.failed = false;

                this.file = document.getElementById('video').files[0];

                this.store().then(() => {
                    var form = new FormData;

                    form.append('video',this.file);
                    form.append('uid',this.uid);

                    axios.post('/upload',form, {
                        onUploadProgress : (e) => {
                            if(e.lengthComputable)
                            {
                                this.updateProgress(e);
                            }
                        }
                    })
                    .then((res) => {
                        this.uploadingComplete = true;
                    })
                    .catch(() => {
                        this.failed = true;
                    });
                });
           },

           store() {
               return axios.post('/videos',{
                   title : this.title,
                   description : this.description,
                   visibility : this.visibility,
                   extension : this.file.name.split('.').pop()
               })
               .then( response => {
                   this.uid = response.data.data.uid;
               })
               .catch(error => {
                   this.failed = true;
                    console.log(error.response);  
               });
           },


           update(){
               this.saveStatus = 'Saving Changes';
              return axios.put(`/videos/${this.uid}`,{
                   title : this.title,
                   description : this.description,
                   visibility : this.visibility,
              })
              .then(response => {
                  this.saveStatus = 'Changes saved.';
              }, (err) => {
                  this.errors = err.response.data;
                  this.saveStatus = 'Failed to save changes.'
              })
           },
           updateProgress(e){
               e.percent = (e.loaded / e.total) * 100;
               this.fileProgress = Math.floor(e.percent);
           }
       },

       watch: {
           saveStatus() {
                setTimeout(() => {
                      this.saveStatus = null;
                  },3000);
           },
           uploadingComplete() {
                setTimeout(() => {
                      this.uploadingComplete = null;
                  },3000);
           },
       },
       mounted () {
           window.onbeforeunload = () => {
               if(this.uploading && !this.uploadingComplete && !this.failed)
               {
                   return 'Are you sure you want to navigate away?';
               }
           }
       },
    }
</script>
