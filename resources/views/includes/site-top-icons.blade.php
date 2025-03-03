<div class="col-6 col-md-4 order-3 order-md-3 text-right">
  <div class="site-top-icons">
    <ul>

      @auth()

        <li><a href="{{ route("dashboard") }}"><span class="icon icon-person"></span></a></li>

        <li>
          <a href="cart.html" class="site-cart">
            <span class="icon icon-shopping_cart"></span>
            <span class="count">2</span>
          </a>
        </li>

      @endauth

      @guest()

        <li><a href="{{ route("login") }}"><span class="icon icon-arrow_forward"></span></a></li>

      @endguest


    </ul>
  </div>
</div>