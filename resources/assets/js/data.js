export default {

    money_full_name: "тенге",
    money_small_name: "тнг.",

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

    subcats: 
    [
        { name: 'Грузовой автомобиль', category_id: 1 },
        { name: 'Легковой автомобиль', category_id: 1 },
        { name: 'Мототехника',         category_id: 1 },
        { name: 'Спецтехника',         category_id: 1 },
        { name: 'Ретро-автомобиль',    category_id: 1 },
        { name: 'Водный транспорт',    category_id: 1 },
        { name: 'Квартира',            category_id: 2 },
        { name: 'Комната',             category_id: 2 },
        { name: 'Дом, дача, коттедж',  category_id: 2 },
        { name: 'Земельный участок',   	   category_id: 2 },
        { name: 'Гараж или машиноместо',   category_id: 2 },
        { name: 'Коммерческая недвижимость',   category_id: 2 },
        { name: 'Недвижимость за рубежом',   category_id: 2 },
        
    ],

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

