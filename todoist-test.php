<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="dnx_logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="pattern.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Todoist API test - dnx.cz</title>
    
</head>
<body>


<!-- Todoist API -->
<script>
import { TodoistApi } from "@doist/todoist-api-typescript";

const api = new TodoistApi("4d1da9b600b9cbbc60c30fe32a51db6bc88ee215");

api.getProjects()
    .then((projects) => {
        console.log(projects);
        // Zobrazíme úkoly na stránce
        const tasksContainer = document.getElementById('tasks-container');
        projects.forEach(project => {
            const projectElement = document.createElement('div');
            projectElement.textContent = project.name;
            tasksContainer.appendChild(projectElement);
        });
    })
    .catch((error) => console.log(error));


</script>
<!-- Todoist API || END -->



</body>
</html>