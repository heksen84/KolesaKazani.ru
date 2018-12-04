export default {

    money_full_name: "тенге",
    money_small_name: "тнг.",

    // максимальное кол-во загружаемых картинок
	max_loaded_images: 10,

    // стандартные операции
    options_sdelka: 
    [
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },
        { value: '3', text: 'Отдам даром' },
        { value: '4', text: 'Сдача в аренду' }
    ],

    // наш объект объявления, куда размещаются все пункты
    advert_data: {},

    // глобальный объект для алертов
    alert: {
        show:false,
        msg:""
    },
}

