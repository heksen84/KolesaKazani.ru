export default {

    money_full_name:    "тенге",
    money_small_name:   "тнг.",
	max_loaded_images: 10,     // максимальное кол-во загружаемых картинок

    options_sdelka:
    [
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },      
        { value: '3', text: 'Отдам даром' },
        { value: '4', text: 'Сдача в аренду' },
        { value: '5', text: 'Другое' }
    ],

    advert_data: {}, // наш объект объявления, куда размещается объявление

    // глобальный объект для алертов
    alert: 
    {
        show:false,
        msg:""
    },
}

