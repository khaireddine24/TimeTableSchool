<div style="min-height: 100vh; display: flex; flex-direction: column; background-color: #f8f9fa;">

    <!-- Navbar with professional styling -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">TimeTable</a>

            <div class="d-flex flex-grow-1 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <a class="nav-link" href="/generate">Generate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/records">Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/archived">Archived</a>
                    </li>
                    @auth
<!-- Logout form (only visible for authenticated users) -->
<form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit" class="text-black nav-link bg-transparent border-0 hover:text-blue-500">
        Logout
    </button>
</form>
@endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h2 class="text-center">Select a Class</h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($classes as $classOption)
                                <li class="list-group-item">
                                    <a href="{{ route('archive.show', $classOption->id) }}" class="text-decoration-none text-body text-bold">
                                        {{ $classOption->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer with a professional look -->
    <footer class="footer mt-auto py-3 bg-dark text-light">
        <div class="container">
            <span class="text-muted">TimeTable Generator © 2024. All rights reserved.</span>
        </div>

    </footer>
</div>