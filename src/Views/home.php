<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Mini Framework - Docs</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div class="centered-container">
            <div class="doc-card">
                <h1 class="h1">📘 Framework Guide</h1>

                <hr class="hr">
                <h2 class="h2">How To Create Controller</h2>
                <p class="p">To create a controller, extend the base <code class="code-inline">Controller</code> and return views or responses from its methods.</p>

                <pre class="pre"><code class="code">
                // Example: HomeController.php

                class HomeController extends Controller
                {
                    public function index(): Response
                    {
                        return $this->view('home', ['name' => 'David']);
                    }
                }
                </code></pre>


                <hr class="hr">
                <h2 class="h2">How To Register Routes</h2>
                <p class="p">Use the <code class="code-inline">Router</code> to map URLs to controller methods or closures.
                    You can register routes for all HTTP methods: <code class="code-inline">GET</code>, <code class="code-inline">POST</code>,
                    <code class="code-inline">PUT</code>, <code class="code-inline">PATCH</code>, <code class="code-inline">DELETE</code>.</p>

                <pre class="pre"><code class="code">
                Routes.php

                use App\Controllers\HomeController;
                use App\Core\Request;
                use App\Core\Response;
                use App\Core\Router;

                // GET routes (standard)
                Router::get('/', [HomeController::class, 'index']);

                // GET route using closure
                Router::get('/home', function () {
                    return new Response("Hello from controller!");
                });

                Router::post('/home', [HomeController::class, 'store']);
                Router::put('/home', [HomeController::class, 'update']);
                Router::patch('/home', [HomeController::class, 'patch']);

                // DELETE route (full closure example)
                Router::delete('/api/data', function (Request $request) {
                    return Response::json([
                        'message' => 'Data deleted',
                        'data' => $request->all()
                    ]);
                });
                </code></pre>


                <hr class="hr">
                <h2 class="h2">How To Use Request</h2>
                <p class="p">The <code class="code-inline">Request</code> class helps you access GET, POST, JSON input, files, and cookies easily. Capture the current request using <code class="code-inline">Request::capture()</code>.</p>

                <pre class="pre"><code class="code">
                // Capture the request
                $request = Request::capture();

                // Get HTTP method
                $method = $request->method(); // GET, POST, etc.

                // Get current path
                $path = $request->path(); // e.g., "/home"

                // Get a single input value
                $name = $request->input('name', 'Guest');

                // Get all input data (GET, POST, JSON)
                $data = $request->all();

                // Check if the request is JSON
                if ($request->isJson()) {
                    $jsonData = $request->all();
                }
                </code></pre>


                <hr class="hr">
                <h2 class="h2">How To Use Response</h2>
                <p class="p">The <code class="code-inline">Response</code> class allows you to return HTML or JSON responses easily. You can also set HTTP status codes and headers.</p>

                <pre class="pre"><code class="code">
                // Return HTML response
                return new Response('&lt;h1&gt;Hello World&lt;/h1&gt;', 200);

                // Return JSON response
                return Response::json([
                    'success' => true,
                    'message' => 'Data saved'
                ]);

                // Send the response to the client
                $response = Response::json(['ok' => true]);
                $response->send();
                </code></pre>


                <hr class="hr">
                <h2 class="h2">How To Use Config</h2>
                <p class="p">
                    You can access configuration values in two ways:
                </p>

                <h3 class="h3">1. Simple direct usage (array)</h3>
                <pre class="pre"><code class="code">
                    $config = require __DIR__ . '/../config/app.php';
                    echo $config['name'];  // MiniFramework
                    echo $config['env'];   // local
                </code></pre>

                <p class="p">
                    This is the simplest way and works well for quick access or scripts.
                </p>

                <h3 class="h3">2. Using the <code class="code-inline">Config</code> loader (recommended)</h3>
                <pre class="pre"><code class="code">
                    // Initialize the Config loader
                    $config = new Config();

                    // Get a single value from 'app' config
                    $appName = $config->get('app', 'name', 'MyApp');

                    // Get all values from 'app' config
                    $appConfig = $config->all('app');

                    // Get all loaded configs
                    $allConfigs = $config->allConfigs();

                    // Example usage in code
                    echo "App Name: " . $appName;
                </code></pre>

                <p class="p">
                    Your <code class="code-inline">AppConfig</code> class should implement
                    <code class="code-inline">ConfigInterface</code> and define the <code class="code-inline">key()</code>,
                    <code class="code-inline">get()</code>, and <code class="code-inline">getAll()</code> methods.
                    This allows the <code class="code-inline">Config</code> loader to access it automatically.
                </p>


                <hr class="hr">
                <h2 class="h2">How To Configure Database Connection</h2>
                <p class="p">
                    To connect your mini framework project to a database, edit the
                    <code class="code-inline">config/database.php</code> file and optionally run
                    <code class="code-inline">composer db-up</code> to test the connection.
                </p>

                <pre class="pre"><code class="code">
                // Example configuration
                return [
                    'driver'   => 'pgsql',       // or 'mysql'
                    'host'     => 'localhost',   // depends on your environment (see below)
                    'port'     => 5432,
                    'database' => 'db-name',
                    'username' => 'db-username',
                    'password' => 'db-password',
                ];

                // Test connection
                composer db-up
                </code></pre>

                <h3><strong>Host options by environment:</strong></h3>
                <ul>
                    <li><strong>Windows or macOS (running locally):</strong> use <code>localhost</code>.</li>
                    <li><strong>WSL (connecting to Windows DB):</strong> use your Windows IP address (run <code>ipconfig</code> on Windows to find it).</li>
                    <li><strong>Docker (app inside container, DB on host):</strong> use <code>host.docker.internal</code> (works on Docker Desktop for Windows/Mac).</li>
                    <li><strong>Remote server:</strong> use the public IP or domain of your database host.</li>
                </ul>

                <p class="p"><strong>Tips:</strong></p>
                <ul>
                    <li>
                        If using WSL or a remote connection, make PostgreSQL listen on your host IP address
                        (e.g., <code>192.168.x.x</code>) in <code>postgresql.conf</code>,
                        and add that same IP (or a range) to <code>pg_hba.conf</code> to allow access.
                        Avoid using <code>0.0.0.0</code> unless necessary, as it opens the server to all interfaces.
                    </li>
                    <li>If connection fails, check firewall and port settings (default port is 5432).</li>
                    <li>Always run <code>composer db-up</code> or migrations from the same environment where your app runs (Docker, WSL, etc.).</li>
                </ul>


                <hr class="hr">
                <h2 class="h2">How To Add Migrations</h2>
                <p class="p">Migrations help you create or modify database tables easily. Each migration class implements <code class="code-inline">MigrationInterface</code> with <code class="code-inline">up()</code> and <code class="code-inline">down()</code> methods.</p>

                <pre class="pre"><code class="code">
                // Example: Create a users table
                namespace App\Core\Database\Migrations;

                use App\Core\Database\MigrationInterface;
                use App\Models\BaseModel;

                class CreateUsersTable implements MigrationInterface
                {
                    public static function up(): void
                    {
                        $sql = "
                            CREATE TABLE IF NOT EXISTS users (
                                id SERIAL PRIMARY KEY,
                                name VARCHAR(100) NOT NULL,
                                email VARCHAR(150) UNIQUE NOT NULL,
                                password VARCHAR(255) NOT NULL,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            );
                        ";
                        BaseModel::execute($sql);
                    }

                    public static function down(): void
                    {
                        BaseModel::execute("DROP TABLE IF EXISTS users;");
                    }
                }
                </code></pre>
                <p class="p">To run migrations:</p>
                <pre class="pre"><code class="code">
                // Run all migrations
                composer migrate
                </code></pre>


                <hr class="hr">
                <h2 class="h2">How To Add Model</h2>
                <p class="p">Models help you interact with database tables. Each model extends <code class="code-inline">BaseModel</code> and defines the table name.</p>

                <pre class="pre"><code class="code">
                // Example: User model
                namespace App\Models;

                class User extends BaseModel
                {
                    protected static string $table = 'users';

                    public static function all(): array
                    {
                        return self::fetchAll("SELECT * FROM " . self::$table);
                    }

                    public static function find(int $id): ?array
                    {
                        return self::fetchOne("SELECT * FROM " . self::$table .
                        " WHERE id = :id", ['id' => $id]);
                    }

                    public static function create(array $data): int
                    {
                        $sql = "INSERT INTO " . self::$table .
                        " (name, email) VALUES (:name, :email)";
                        self::execute($sql, $data);
                        return (int) self::lastInsertId();
                    }
                }
                </code></pre>
                <p class="p">Usage example:</p>
                <pre class="pre"><code class="code">
                // Get all users
                $users = User::all();

                // Find a user by ID
                $user = User::find(1);

                // Create a new user
                $newUserId = User::create([
                    'name' => 'John Doe',
                    'email' => 'john@example.com'
                ]);
                </code></pre>


                <hr class="hr">
                <h2 class="h2"> How to Use Container</h2>
                <p class="p">The <code class="code-inline">Container</code> allows you to **bind, resolve, and manage dependencies** in your application. You can register classes, singletons, or instances and get them anywhere.</p>

                <pre class="pre"><code class="code">
                // Get the container instance (singleton)
                $container = Container::getInstance();

                // Bind a class (factory)
                $container->bind(App\Services\Mailer::class, function ($c) {
                    return new App\Services\Mailer($c->get(App\Config\AppConfig::class));
                });

                // Bind a singleton
                $container->singleton(App\Services\Logger::class, function ($c) {
                    return new App\Services\Logger();
                });

                // Register an already created instance
                $container->instance(App\Services\Session::class, new App\Services\Session());

                // Resolve a class (automatic dependency injection)
                $mailer = $container->get(App\Services\Mailer::class);
                $logger = $container->get(App\Services\Logger::class);

                // Now you can use them
                $mailer->send('test@example.com', 'Hello!');
                $logger->log('Sent email');
                </code></pre>

                <p class="p">
                    The <code class="code-inline">Container</code> automatically resolves dependencies via constructor injection.
                    You can use <code class="code-inline">bind</code> for new instances every time, <code class="code-inline">singleton</code> for shared instances, and <code class="code-inline">instance</code> to register an already created object.
                </p>

            </div>
        </div>
    </body>
</html>