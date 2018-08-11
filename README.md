# Обновление обложки в группе в ВК

Скрипт изменения обложки в ВК генерирует обложку, помещая на нее пользователя, вступившего в сообщество и пользователя, поставившего наибольшее количество лайков за определенный промежуток времени.

Посмотреть [Демо](https://vk.com/vkgroupcover) :eyes:.

По всем вопросам можно писать [в личку](https://vk.com/im?sel=92682082) в ВК или на <savelev.aleksandr.96@yandex.ru>.

### Функционал
- Отправка сообщений пользователям от имени группы
- Помещение на обложку группы аватара, имени и фамилии вступившего в группу пользователя
- Помещение на обложку группы аватара, имени и фамилии пользователя, поставившего наибольшее количество лайков за определенный промежуток времени
- Получение информации о пользователе
- Получение пользователя, поставившего наибольшее количество лайков за определенный промежуток времени
- Получение постов группы или пользователя
- Получение лайков у постов, фотографий, видео, комментариев и т.д.
- Изменение обложки группы

### Возможности настройки
- Расположить аватар, имя и фамилию по заданным координатам
- Менять размер и форму аватара: квадратную или круглую
- Менять шрифт, размер, цвет, выравнивание, угол наклона текста
- Менять промежуток времени по которому выбирается пользователь поставивший наибольшее количество лайков

## Настройка
1. Скрипт необходимо загрузить на Ваш сервер.
2. В настройках группы, в разделе Работа с API получить ключ доступа с правами доступа к: управление сообществом, фотографии, стена.
3. Вставить ключ доступа в файл config.php в поле `access_token`.
4. На той же странице настроек группы перейти на вкладку Callback API и ввести URL до скрипта на Вашем сервере (пример: https://savelev.xyz/vk_cover/index.php).
5. С этой же страницы настроек скопировать ID группы и строку (которую должен вернуть скрипт), и вставить в файл config.php в поля `group_id` и `confirmation_token` соответственно, и нажать кнопку Подтвердить на странице настроек.
6. На вкладке Типы событий выбрать Вступление в сообщество.
7. Сервисный ключ не работает. Работает только ключ пользователя, полученный методом [Прямой авторизации](https://vk.com/dev/auth_direct) . Ключ пользователя скопировать в файл config.php в поле `service_token`. (client_id и client_secret можно найти [в интернете](https://sohabr.net/habr/post/233439/))
