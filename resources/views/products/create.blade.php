@vite('resources/scss/app.scss')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SimpleCart</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home') }}" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}" style="color: white;">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart') }}" style="color: white;">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<body>
    <h1>Add Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>
        <label>Stock:</label>
        <input type="number" name="stock" required>
        <button type="submit">Save</button>
    </form>
</body>
</html>
