<template>

    <div class="container">
       <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                 
                    <button class="btn btn-success " @click="newModel">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                  
                </div>
              </div>


              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Registered At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id" >
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.created_at | myData}}</td>
                      <td>
                          <a href="#" @click="editModel(user)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                           /
                          <a href="#" @click="deleteUser(user.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- Modal -->
            <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode" id="AddNewModalLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editMode" id="AddNewModalLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateUser(): createUser()">
                  <div class="modal-body">
                  
                      <div class="form-group">
                          
                          <input v-model="form.name" type="text" name="name"
                              placeholder="name"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                      </div>

                      <div class="form-group">
                          
                          <input v-model="form.email" type="email" email="email"
                              placeholder="Email Address"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                      </div>

                      <div class="form-group">
                          
                          <input v-model="form.password" type="password" name="password" id="password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                      </div>

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                      <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                  </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</template>

<script>
    export default {
        data() {
            return{
              editMode : false,
              users : {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
          updateUser(id) {
            this.$Progress.start();
              //console.log('update');
              this.form.put('api/user/' + this.form.id)
              .then(() => {
                    //success
                    $('#AddNewModal').modal('hide');
                     Swal.fire(
                          'updated!',
                          'Information has been updated.',
                          'success'
                      )
                      this.$Progress.finish();
                      Fire.$emit('AfterCreated');
              })
              .catch(() => {
                this.$Progress.fail();
              });
          },
          editModel(user){
            this.editMode = true;
            this.form. reset();
            $('#AddNewModal').modal('show');
            this.form.fill(user);
          },
          newModel(){
            this.editMode = false;
            this.form.reset();
            $('#AddNewModal').modal('show');
          },
          deleteUser(id){
               Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                  
                      //send a request to the server
                  if (result.value) {
                      this.form.delete('api/user/'+ id).then(()=>{
                        Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        )
                        Fire.$emit('AfterCreated')
                      
                      }).catch(()=>{
                          swal("Failed!","There is something wrong.","Warning");
                      })
                  }

                })

          },
          loadUsers(){
              axios.get("api/user").then(({data}) => (this.users = data.data));
              
          },

          createUser(){
              this.$Progress.start();
              this.form.post('api/user')
              .then(()=>{
                Fire.$emit('AfterCreated')

                 $('#AddNewModal').modal('hide');

                     Toast.fire({
                         icon: 'success',
                         title: 'Signed in successfully'
                      })
                     this.$Progress.finish();
              })
              .catch(()=>{

              })
              
          }
        },
        created(){
            this.loadUsers();
            Fire.$on('AfterCreated', () => {
              this.loadUsers()
              });
            //setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
