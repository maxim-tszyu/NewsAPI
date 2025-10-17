<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Новая новость опубликована</title>
</head>
<body>
<h2>Здравствуйте, {{ $author }}!</h2>
<p>Ваша новость "<strong>{{ $title }}</strong>" успешно опубликована.</p>
<p>Дата публикации: {{ $publish_date }}</p>
<p>Спасибо за ваш вклад в портал новостей!</p>
</body>
</html>
