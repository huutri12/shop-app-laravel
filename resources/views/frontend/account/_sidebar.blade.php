<div class="left-sidebar">
  <h2>ACCOUNT</h2>
  <div class="panel-group category-products" id="accordian">
    <div class="panel panel-default">
      <div class="panel-heading {{ request()->routeIs('account.update*') ? 'active' : '' }}">
        <h4 class="panel-title">
          <a href="{{ route('account.update') }}">Account</a>
        </h4>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading {{ request()->routeIs('account.my-product*') ? 'active' : '' }}">
        <h4 class="panel-title">
          <a href="{{ route('account.my-product') }}">My Product</a>
        </h4>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading {{ request()->routeIs('account.add-product') ? 'active' : '' }}">
        <h4 class="panel-title">
          <a href="{{ route('account.add-product') }}">Add Product</a>
        </h4>
      </div>
    </div>
  </div>
</div>
