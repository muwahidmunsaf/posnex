<!doctype html>
<html lang="en">
  <head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  </head>

  <body>
    <header>
      <!-- place navbar here -->
    </header>
    <main>
      <div class="container-fluid mt-5">
    <div class="container">
  <!-- Hero Section -->
  <div class="row align-items-center">
    <div class="col-md-6">
      <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-primary"> {{ config('app.name', 'Laravel') }}</span></h1>
      <p class="lead mb-4">
        Streamline your sales, manage inventory, and grow your business with our powerful Point of Sale web application.
      </p>
      @guest
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Login</a>
        <a href="{{ url('#') }}" class="fs-5 text-primary text-decoration-underline">Book Now</a>
      @else
        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">Go to Dashboard</a>
      @endguest
    </div>
    <div class="col-md-6 text-center">
      <img src="https://cdn-icons-png.flaticon.com/512/1087/1087841.png" alt="POS illustration" class="img-fluid" style="max-height: 350px;">
    </div>
  </div>

  <!-- Features Section -->
  <section class="mt-5">
    <h2 class="text-center mb-4">Features</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-cart-check-fill fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Effortless Sales</h5>
            <p class="card-text">Quickly process transactions with an intuitive sales interface optimized for speed and accuracy.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-box-seam fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Inventory Management</h5>
            <p class="card-text">Track stock levels, get low-stock alerts, and manage suppliers with ease.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-graph-up fs-1 text-primary mb-3"></i>
            <h5 class="card-title">Reports & Analytics</h5>
            <p class="card-text">Gain insights into sales trends, customer behavior, and business performance.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer CTA -->
  <section class="text-center mt-5 mb-5">
    <h3 class="mb-3">Ready to transform your business?</h3>
    @guest
      <a href="#" class="btn btn-lg btn-primary">Get Started Now</a>
    @else
      <a href="{{ route('dashboard') }}" class="btn btn-lg btn-success">Go to Dashboard</a>
    @endguest
  </section>
</div>
</div>

    </main>
    <footer>
    <!-- Developer Company Info Section -->
    <section class="bg-light p-3 py-4 mt-5 rounded shadow-sm">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h5 class="mb-2">Developed by <a href="https://devzyte.com" target="_blank" rel="noopener" class="text-decoration-none">DevZyte</a></h5>
          <p class="mb-1">
            DevZyte provides expert services in <strong>Website Development, Digital Marketing, SEO/SMM</strong>, and <strong>Custom Websites & Web Applications</strong>.
          </p>
          <p class="mb-0">
            Contact: <a href="mailto:info@devzyte.com">info@devzyte.com</a> | (+92) 346-7911195
          </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
          <a href="https://devzyte.com" target="_blank" rel="noopener" class="btn btn-outline-primary">Visit DevZyte</a>
        </div>
      </div>
    </section>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
