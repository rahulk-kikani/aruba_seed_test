<div class="row" ng-controller="boatController" ng-show="$root.tabs[$root.active_tab_index]['id'] == 'boat'">
  <div class="col-xs-3">
    <!-- quick email widget -->
      <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-envelope"></i>

          <h3 class="box-title">Add Boat Detail</h3>
        </div>
        <div class="box-body">
          <form action="#" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="name" placeholder="Name:" ng-model="newboat.name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="price" placeholder="Price:" ng-model="newboat.price">
            </div>
            <div class="form-group">
              <label>Color</label><br/>
              <select name="singleSelect" ng-model="newboat.color">
                <option ng-repeat="color in boatColors" value="{{color}}">{{color}}</option>
              </select>
            </div>
          </form>
        </div>
        <div class="box-footer clearfix">
          <button type="button" class="pull-right btn btn-default" id="saveboat" ng-disabled="newboat.name == '' || newboat.price == ''" ng-click="save_boat()">Add
            <i class="fa fa-arrow-circle-right"></i></button>
        </div>
      </div>
  </div>
  <div class="col-xs-9">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Boat List</h3>

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
            <th>Name</th>
            <th>Price</th>
            <th>Color</th>
            <th>Action</th>
          </tr>
          <tr ng-repeat="boat in $root.boats">
            <td class="text-center">{{ boat.id }}</td>
            <td>{{ boat.name }}</td>
            <td>${{ boat.price }}</td>
            <td>{{ boat.color }}</td>
            <td><button class="btn btn-primary" ng-click="get_books_on_boat(boat.id)">View</button></td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>

  <div class="modal fade" id="boatBooksModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Books on Boat Detail</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive no-padding">
          <div class="form-group">
            <div class="" ng-show="filteredBooks.length > 0">
              <div class="col-md-3" style="padding: 7px;"><label>Add New Book: </label></div>
              <div class="col-md-7">
                <select class="form-control" name="singleSelect" ng-model="currentBoat.id_book">
                  <option ng-repeat="book in filteredBooks" value="{{book.id}}">{{book.name}}</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-success" ng-click="add_new_book_to_boat()">Add</button>
              </div>
            </div>
          </div>
          <br/>
          <br/>
          <table class="table table-hover">
            <tr>
              <th class="text-center">ID</th>
              <th>Title</th>
              <th>Link</th>
            </tr>
            <tr ng-repeat="book in boatBooks">
              <td class="text-center">{{ book.id }}</td>
              <td>{{ book.name }}</td>
              <td><a href="{{ book.url_on_amazon }}" target="_blank">{{ book.url_on_amazon }}</a></td>
            </tr>
          </table>
          <span ng-if="boatBooks.length == 0">No book on boat.</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>