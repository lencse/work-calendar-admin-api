task default: %w[build]

DOCKER_COMPOSE = 'docker-compose'
DOCKER_PHP = "#{DOCKER_COMPOSE} run php"

task :build do
    sh "#{DOCKER_COMPOSE} stop"
    sh "#{DOCKER_COMPOSE} build"
    sh "#{DOCKER_COMPOSE} up -d"
    sh "#{DOCKER_PHP} composer install"
    sh "#{DOCKER_PHP} bin/console doctrine:schema:update"
end

task :test do
    sh "#{DOCKER_PHP} vendor/bin/phpunit"
end
