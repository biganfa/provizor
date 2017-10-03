pipeline {
    environment {
        SECRET = credentials('aaa28e35-e29a-4cab-a885-1b2d6c881c31')
    }
    agent any
    stages {
        stage('build') {
            steps {
                sh 'php --version >> /tmp/php_version'
            }
        }
    }
    post {
        always {
            sh 'echo provizor/Jenkinsfile >> /tmp/trash'
        }
    }
}
