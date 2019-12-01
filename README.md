# maxidom.map
Модуль создания и редактирования зон доставки на Яндекс-карте

Для установки модуля скопировать его в директорию /bitrix/modules/ и установить через меню Marketplace -> Установленные решения.

Меню модуля находится в разделе Настройки -> Настройки модулей -> Зоны доставки.

Если карта не отображается то надо поставить галочку "Включить jQuery" и Применить.

Для рисования многоугольника нужно нажать на кнопку "Включить режим редактирования"
Для завершения рисования нажать "Остановить режим редактирования", при этом данные о нарисованном многоугольнике сразу сохранятся в Базе данных.
Для рисования новой зоны доставки следует обновить страницу.

Кнопка "Отредактировать цвета и названия" позволяет редактировать только те зоны доставки, которые были на момент создания страницы, и для новых зон доставки следует обновить страницу.

Если надо изменить масштаб и центр карты, то достаточно изменить их на карте, после чего нажать кнопку "Включить режим редактирования" и сразу "Остановить режим редактирования". Данные параметры будут считаны с карты и записаны в базу.

Установка компонента производится стандартными средствами. Сам компонент находится по пути "Мои компоненты" -> "Вывод карты".
Для ручной установки достаточно скопировать на страницу код:

&lt;$APPLICATION->IncludeComponent(
	"maxidom:maxidom.map",
	"",
Array()
);&gt;
