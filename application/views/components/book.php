<div class="row" ng-controller="bookController" ng-show="$root.tabs[$root.active_tab_index]['id'] == 'book'">
  <div class="col-xs-3">
    <!-- quick email widget -->
      <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-envelope"></i>

          <h3 class="box-title">{{ 'titles.add_book_detail' | i18next}}</h3>
        </div>
        <div class="box-body">
          <form action="#" method="post" name="bookForm">
            <div class="form-group">
              <input type="text" class="form-control" name="book_name" maxlength="50" placeholder="{{ 'attr.title' | i18next}}:" ng-model="newbook.name" required="">
              <p ng-show="bookForm.book_name.$invalid && !bookForm.book_name.$pristine" class="help-block error-block">{{ 'errors.book_name' | i18next }}</p>
            </div>
            <div class="form-group">
              <input type="url" class="form-control" name="url_on_amazon" maxlength="255" placeholder="{{ 'attr.link' | i18next}}:" ng-model="newbook.url_on_amazon" required="">
              <p ng-show="bookForm.url_on_amazon.$invalid && !bookForm.url_on_amazon.$pristine" class="help-block error-block">{{ 'errors.url_on_amazon' | i18next }}</p>
            </div>
          </form>
        </div>
        <div class="box-footer clearfix">
          <button type="button" class="pull-right btn btn-default" id="saveBook" ng-disabled="newbook.first_name == '' || newbook.url_on_amazon == '' || newbook.has_skipair === '' || bookForm.$invalid" ng-click="save_book()">{{ 'buttons.add' | i18next }}
            <i class="fa fa-arrow-circle-right"></i></button>
        </div>
      </div>
  </div>
  <div class="col-xs-9">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{ 'titles.book_list' | i18next}}</h3>

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
            <th class="text-center">{{ 'attr.id' | i18next}}</th>
            <th>{{ 'attr.title' | i18next}}</th>
            <th>{{ 'attr.link' | i18next}}</th>
          </tr>
          <tr ng-repeat="Book in $root.books">
            <td class="text-center">{{ Book.id }}</td>
            <td>{{ Book.name }}</td>
            <td><a href="{{ Book.url_on_amazon }}" target="_blank">{{ Book.url_on_amazon }}</a></td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>