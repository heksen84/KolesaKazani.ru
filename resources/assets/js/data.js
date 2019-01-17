export default {

    money_full_name:    "тенге",
    money_small_name:   "тнг.",

    // максимальное кол-во загружаемых картинок
	max_loaded_images: 10,

    // стандартные операции
    options_sdelka: 
    [
        { value: '1', text: 'Покупка' },
        { value: '2', text: 'Продажа' },
        { value: '3', text: 'Обмен' },
        { value: '4', text: 'Частичный обмен' },
        { value: '5', text: 'Отдам даром' },
        { value: '6', text: 'Сдача в аренду' }
    ],

    // подкатегории
    /*subcats:
    [
        { name: 'Грузовой автомобиль',       url: "gruzovoy_automobil",  category_id: 1 },
        { name: 'Легковой автомобиль',       url: "legkovoy_automobil",  category_id: 1 },
        { name: 'Мототехника',               url: "mototechnika",        category_id: 1 },
        { name: 'Спецтехника',               url: "spectehinka",         category_id: 1 },
        { name: 'Ретро-автомобиль',          url: "",  category_id: 1 },
        { name: 'Водный транспорт',          url: "",  category_id: 1 },
        { name: 'Квартира',                  url: "",  category_id: 2 },
        { name: 'Комната',                   url: "",  category_id: 2 },
        { name: 'Дом, дача, коттедж',        url: "",  category_id: 2 },
        { name: 'Земельный участок',   	     url: "",  category_id: 2 },
        { name: 'Гараж или машиноместо',     url: "",  category_id: 2 },
        { name: 'Коммерческая недвижимость', url: "",  category_id: 2 },
        { name: 'Недвижимость за рубежом',   url: "",  category_id: 2 },
        
    ],*/

    // --------------------------------------------------------
    // наш объект объявления, куда размещается объявление
    // --------------------------------------------------------
    advert_data: {},

    // глобальный объект для алертов
    alert: {
        show:false,
        msg:""
    },
}

