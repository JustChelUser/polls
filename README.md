# polls
Создание опросов для школы<br>
# Описание
Сайт позволяет автоматизировать процесс создания и прохождения опроса, а также обработки его результатов.<br>
# Типы пользователей с их возможностями<br>
Администратор имеет следущие возможности:<br>
⎯ добавление пользователей;<br>
⎯ изменение данных пользователей;<br>
⎯ удаление пользователей;<br>
⎯ просмотр данных существующих пользователей;<br>
⎯ предоставление доступа к опросу;<br>
⎯ добавление опроса;<br>
⎯ прохождение опроса;<br>
⎯ просмотр списка опросов и редактирование названий добавленных опросов;<br>
⎯ просмотр результата прохождения опросов;<br>
⎯ формирование отчёта о прохождении опроса;<br>
⎯ добавление, редактирование учебных классов;<br>
⎯ просмотр списка учебных классов.<br>
Учитель имеет следущие возможности:<br>
⎯ предоставление доступа к опросу;<br>
⎯ просмотр списка опросов;<br>
⎯ прохождение опроса;<br>
⎯ просмотр результата прохождения опроса;<br>
⎯ формирование отчёта о прохождении опроса.<br>
Ученик или родители ученика имеют возможность проходить  опросы, к которым им предоставлен доступ.<br>
# Установка (на примере Open Server Panel)
Папку с проектом необходимо поместить в директорию «domains» установленного Open Server Panel.<br>
Зайти в phpMyAdmin используя стандартные данные для входа (логин - root).<br>
Произвести импорт данных в базу данных используя файл myPoll.sql.<br>
Зайти на адрес : http://localhost/login.php.<br>
Данные администратора по умолчанию :<br>
Логин - NewAdmin<br>
Пароль - NewAdmin1!<br>
