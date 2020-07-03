<style>
.widget-user-header {
    background-position: center center;
    background-size: contain;
}
</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg')">
                <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>


            </div>
        </div>

         <div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                   <div class="post">
                       No Activity
                   </div>
                  </div>

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-12">
                          <input type="name" v-model="form.name" class="form-control" id="inputName" placeholder="Name" 
                          :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-12">
                          <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email" 
                          :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-12">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                        <div class="col-sm-12">
                          <input type="file" @change="LoadProfile" class="form-input" name="photo">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-sm-12 col-form-label">password(leave empty if nothing change)</label>
                        <div class="col-sm-12">
                          <input type="password" v-model="form.password" class="form-control" id="password" placeholder="password" 
                          :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-offset-sm-2 col-sm-12">
                          <button type="submit" @click.prevent="UpdateInfo" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
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
                form: new form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
          getProfilePhoto(){
           // return "img/Profile/"+ this.form.photo;
           let photo = "/static/default-profile.png";
             if (this.form.photo) {
               if (this.form.photo.indexOf('base64') != -1) {
                   photo = this.form.photo;
               } else {
                   photo = 'img/profiles/' + this.form.photo;
                  }
              }
               return photo;
          },
            UpdateInfo() {
                this.$Progress.start()
                if(this.form.password == '') {
                  this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(() => {

                    this.$Progress.finish()

                })
                .catch(() => {

                    this.$Progress.fail()

                })
            },
            LoadProfile(e) {
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();
                if(file['size'] < 2111775) {
                    reader.onloadend = (file) => {
                   // console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
                }
                else{
                    Swal.fire({
                        type: 'error',
                        title: 'oops...',
                        text: ' You are uploading a large file',
                    });
                }
                
                    
            }
        },

        created() {
            axios.get("api/profile").then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
