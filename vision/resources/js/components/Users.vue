<template>
    <div class="container">
       <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
               
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal"> Add New <i class="fas fa-user-plus "></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type}}</td>
                      <td>{{user.created_at | myDate}}</td>
                      <td>
                          <a href="#" @click="editModal(user)">
                              <i class="fa fa-edit"></i>
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
              <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>

         <!-- Modal -->
            <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="AddNewLabel">Add User</h5>
                    <h5 class="modal-title" v-show="editmode" id="AddNewLabel">Update User </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ?updateUser() :createUser()">
                <div class="modal-body">  
                   <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                                placeholder="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.email" type="text" name="email"
                                placeholder="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea v-model="form.bio" type="text" name="bio"
                                placeholder="short  bio for user (optional)"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>

                     <div class="form-group">
                        <select v-model="form.type" type="text" name="type"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">select user role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                            </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.password" type="password" name="password" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" v-show="!editmode" class="btn btn-primary">Create</button>
                    <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
                </div>
                </form>
                </div>
            </div>
            </div>    
    
    </div>
</template>

<script>
    export default {

        data() {
           return {
               editmode : false,
               users : {},
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

        methods: {

            getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
		    },

            loadUsers() {
               if(this.$gate.isAdminOrAuthor()){
                  axios.get("api/user").then(({data}) => (this.users = data));
               }
              
    
            },
            updateUser() {
                this.$Progress.start()
                //console.log('editing modal');
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                     $('#AddNew').modal('hide');
                   Swal.fire(
                       'updated!',
                       'updated successfully.',
                         'success'
                     ) 
                     Fire.$emit('AfterCreate');
                     this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#AddNew').modal('show');
            },
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#AddNew').modal('show');
                this.form.fill(user);
            },
            deleteUser(id) {
                 Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                            // send an ajax request
                            this.form.delete('api/user/'+id).then(()=> {
                            
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                                Fire.$emit('AfterCreate');
                            }).catch(()=> {
                                Swal.fire("Failed", "There is something wrong", "warning");
                            });
                            }
                        })
            },
            createUser() {
                this.$Progress.start()
                this.form.post('api/user')
                .then(() =>{
                     Fire.$emit('AfterCreate');
                    $('#AddNew').modal('hide');

                    Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                    })
                    this.$Progress.finish()

                })
                .catch(() =>{

                })
               
            }
        },
        mounted() {
            Fire.$on('searching', () =>{
                let query = this.$parent.search;
                axios.get('api/finduser?q' + query)
                .then((data) =>{
                    this.users = data.data
                })
                .catch(() =>{

                })
            })
           this.loadUsers();
           Fire.$on('AfterCreate', () =>{
               this.loadUsers()
           });
          // setInterval(()=> this.loadUsers(),3000);
        }
    }
</script>
