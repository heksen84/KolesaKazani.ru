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

    // наш объект объявления, куда размещаются все пункты
    advert_data: {},

    // глобальный объект для алертов
    alert: {
        show:false,
        msg:""
    },
}

