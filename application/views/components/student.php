<div class="row" ng-controller="studentController" ng-show="$root.tabs[$root.active_tab_index]['id'] == 'student'">
  <div class="col-xs-3">
    <!-- quick email widget -->
      <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-envelope"></i>

          <h3 class="box-title">Add Student Detail</h3>
        </div>
        <div class="box-body">
          <form action="#" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="first_name" placeholder="First Name:" ng-model="newstudent.first_name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="last_name" placeholder="Last Name:" ng-model="newstudent.last_name">
            </div>
            <div class="form-group">
              <label>Ski Pair Status</label><br/>
              <div class="row">
                <div class="col-xs-6">
                  <label>
                    <input type="radio" class="flat-red" ng-value="true" ng-model="newstudent.has_skipair" ng-checked="newstudent.has_skipair == true">
                      Yes
                  </label>
                </div>
                <div class="col-xs-6">
                  <label>
                    <input type="radio" class="flat-red" ng-value="false" ng-model="newstudent.has_skipair" ng-checked="newstudent.has_skipair == false">
                      No
                  </label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="box-footer clearfix">
          <button type="button" class="pull-right btn btn-default" id="saveStudent" ng-disabled="newstudent.first_name == '' || newstudent.last_name == '' || newstudent.has_skipair === ''" ng-click="save_student()">Add
            <i class="fa fa-arrow-circle-right"></i></button>
        </div>
      </div>
  </div>
  <div class="col-xs-9">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Student List</h3>

        <div style="display: none;" class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th class="text-center">ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Ski Pair Statu</th>
          </tr>
          <tr ng-repeat="student in $root.students">
            <td class="text-center">{{ student.id }}</td>
            <td>{{ student.first_name }}</td>
            <td>{{ student.last_name }}</td>
            <td><span class="label" ng-class="{'label-success': student.has_skipair == 1, 'label-danger': student.has_skipair == 0}">{{ student.has_skipair == 1 ? 'Yes' : 'No' }}</span></td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>