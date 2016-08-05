<div ng-controller="oceanController" ng-show="$root.tabs[$root.active_tab_index]['id'] == 'ocean'">
  <div class="row">
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>150</h3>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>44</h3>

          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <div class="row">
    <div ng-repeat="boat in $root.oceanBoats">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header"
            ng-class= "{
              'bg-red': boat.color == 'RED',
              'bg-blue': boat.color == 'BLUE',
              'bg-navy': boat.color == 'NAVY_BLUE',
              'bg-green': boat.color == 'GREEN',
              'bg-purple': boat.color == 'PURPLE',
            }"
          >
            <h3 class="widget-user-username">{{ boat.id }}. {{ boat.name }} </h3>
            <h5 class="widget-user-desc">{{ boat.color }}</h5>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ boat.seat_occupied }}/{{ boat.max_limit }}</h5>
                  <span class="description-text"><i class="fa fa-user"></i></span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ boat.books.length }}</h5>
                  <span class="description-text"><i class="fa fa-book"></i></span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">{{ boat.skipair_count }}/4</h5>
                  <span class="description-text"><i class="fa fa-steam"></i></span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th class="text-center">ID</th>
                    <th>Name</th>
                    <th><i class="fa fa-steam"></i></th>
                    <td><i class="fa fa-retweet"></i></td>
                  </tr>
                  <tr ng-repeat="student in boat.students">
                    <td class="text-center">{{ student.id_student }}</td>
                    <td>{{ student.first_name }}, {{ student.last_name }}</span></td>
                    <td><span class="label" ng-class="{'label-success': student.has_skipair == 1, 'label-danger': student.has_skipair == 0}">{{ student.has_skipair == 1 ? 'Yes' : 'No' }}</span></td>
                    <td>
                      <span class="label label-primary relocate-btn" ng-click="pre_relocate_student(student.id, $parent.$index)">
                        <i class="fa fa-retweet"></i>
                      </span>
                      <span class="label label-info relocate-btn" ng-click="edit_student($index, $parent.$index)">
                        <i class="fa fa-pencil"></i>
                      </span>
                      <span class="label label-danger relocate-btn" ng-click="remove_student(student.id_student, boat.id)">
                        <i class="fa fa-times"></i>
                      </span>
                    </td>
                  </tr>
                  <tr colspan="4">
                    <button type="button" class="btn btn-primary btn-block btn-sm" ng-click="pre_add_student(boat.id)"> + Add Student </button>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="relocateStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Select Destination Boat</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="" ng-show="filteredBoats.length > 0">
              <div class="col-md-3" style="padding: 7px;"><label>Destination Boat: </label></div>
              <div class="col-md-7">
                <select class="form-control" name="singleSelect" ng-model="relocateStudent.id_boat">
                  <option ng-repeat="boat in filteredBoats" value="{{boat.id}}">{{boat.id}}. {{boat.name}}</option>
                </select>
              </div>
            </div>
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" >Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Student Detail</h4>
        </div>
        <div class="modal-body">
          <form action="#" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="first_name" placeholder="First Name:" ng-model="currentStudent.first_name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="last_name" placeholder="Last Name:" ng-model="currentStudent.last_name">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveStudent" ng-disabled="currentStudent.first_name == '' || currentStudent.last_name == ''" ng-click="update_student()">Update
            <i class="fa fa-arrow-circle-right"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Select Student</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="" ng-show="filteredStudents.length > 0">
              <div class="col-md-3" style="padding: 7px;"><label>Student: </label></div>
              <div class="col-md-7">
                <select class="form-control" name="singleSelect" ng-model="addStudent.id_student">
                  <option ng-repeat="student in filteredStudents" value="{{student.id}}">{{student.id}}. {{student.first_name}}, {{student.last_name}}</option>
                </select>
              </div>
            </div>
          </div>
          <br/>
          <span ng-if="filteredStudents.length == 0">No student left for boading.</span>
        </div>
        <div class="modal-footer">
          <button ng-show="filteredStudents.length > 0" type="button" class="btn btn-primary" id="saveStudent" ng-disabled="currentStudent.first_name == '' || currentStudent.last_name == ''" ng-click="add_student_to_board()">Add
            <i class="fa fa-arrow-circle-right"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>