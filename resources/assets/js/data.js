export default 
{

    // максимальное кол-во загружаемых картинок
	max_load_images: 20,

    options_sdelka: 
    [
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },
        { value: '3', text: 'Частичный обмен' },
        { value: '4', text: 'Отдам даром' },
        { value: '5', text: 'Сдача в аренду' }
    ],

    // структура объявления 
    advert:
    [{   
        deal_selected:null, 
        category:null, 
        text:"",
        price:0,
        images:[],
        location:[],
        chars:[] 
    }]


    function testFunction(param)  {
        
    }
}