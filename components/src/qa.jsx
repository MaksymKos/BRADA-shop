import React, { useEffect } from "react"
import { Accordion } from "./Accordeon";
import Icons from "./icons";

const requestAccordeon = [
    {
        q: 'Створення замовлення',
        a: 'Після того, як ви знайдете бажаний товар, виберіть його розмір та натисніть кнопку «Додати до кошика». У вас є можливість продовжити покупки або ж негайно перейти до оформлення замовлення. Ми спростили процес замовлення, щоб зробити його для вас якнайзручнішим. Незалежно від кількості товарів, вам потрібно буде заповнити форму лише один раз. А важливий момент: коли ваша посилка буде готова до відправки, ви отримаєте SMS-повідомлення з номером декларації. Це дозволить вам відслідковувати ваше замовлення на всіх етапах доставки та бути в курсі процесу.'
    },
    {
        q: 'Доставка',
        a: 'Під час оформлення вашого замовлення, у вас є можливість вибрати один із наступних способів доставки: <br/> 1. **Самовивіз** - Ви зможете забрати ваше замовлення у зручний для вас час із нашого офісу, розташованого у місті Вінниця.<br/> 2. **Доставка через компанію "Нова Пошта"** - Ми пропонуємо доставку до відділення "Нова Пошта" по всій Україні. Зазвичай, час доставки становить 1-2 дні. Після відправлення вашого замовлення, ви отримаєте SMS-повідомлення з номером експрес-накладної, за допомогою якої ви завжди зможете перевірити статус вашого замовлення. Також у додатку "Нова Пошта" є можливість відслідковувати місцезнаходження вашого замовлення. Коли посилка дійде до відділення, ви отримаєте SMS-сповіщення. Будь ласка, отримайте своє замовлення протягом 5 робочих днів після прибуття, інакше воно автоматично повернеться до магазину.<br/> 3. **Кур\'єрська доставка через компанію "Нова Пошта"** - Ми також пропонуємо доставку прямо до вашої вказаної адреси. Перед прибуттям кур\'єр з "Нової Пошти" зв\'яжеться з вами для уточнення зручного часу доставки.'
    }
]

const exchangeAccordeon = [
    {
        q: 'Умови повернення та обміну',
        a: 'Ви маєте можливість повернути або обміняти придбаний товар впродовж 14 днів з моменту покупки. <br/>Ця можливість гарантується вам згідно із «Законом про захист прав споживачів». Для того, щоб скористатися цим правом, прохання впевнитися в наступному: <br/>1. Товар не був використаний та не має слідів експлуатації, таких як подряпини, сколи, потертості і т.п.<br/>2. Товар має повний комплект і не порушена цілісність його упаковки.<br/>3. Всі ярлики та заводське маркування збережені. <br/> Отже, ви маєте право обміняти товар відповідної якості, якщо він не відповідає вашим очікуванням за формою, розміром, фасоном, кольором або іншими параметрами, або ж якщо ви не можете використовувати його з інших причин. Обмін товару відповідної якості здійснюється лише у випадку, якщо він не був вжитим у використання та зберіг свій товарний вигляд, властивості, пломби та ярлики.'
    },
    {
        q: 'Як здійснити обмін чи повернення',
        a: 'Якщо товар відправлено з іншого міста, то ви зобов\'язані оплатити всі витрати, пов\'язані з процедурою повернення. Не приймаються посилки, для яких не сплачена доставка для повернення. Після повернення товару, повернення коштів відбувається протягом 5 банківських днів після того, як посилка прибула до магазину. В цей період проводиться огляд товару, передається інформація до бухгалтерії, і потім кошти повертаються на вашу карту або рахунок. Кожна посилка має страхування, і саме тому ми закликаємо отримувача уважно перевірити посилку на наявність пошкоджень або порушень цілісності. У разі виявлення будь-яких недоліків, будь ласка, негайно зателефонуйте нашому менеджеру, який готовий надати консультацію щодо подальших дій. Якщо ви оглядаєте посилку поза відділенням "Нова Пошта" (наприклад, отримуєте її від кур\'єра), ми готові надати оперативну підтримку та надіслати товар на заміну, в той час, коли ми вирішуємо питання з транспортною компанією. Це означає, що ви не понесете фінансових втрат і отримаєте заміну товару, який був пошкоджений під час транспортування.'
    }
]

const QA = () => {
    useEffect(() => {
        const hash = window.location.hash
        console.log(hash, 'hash');
        if (hash) {
            const el = document.querySelector(hash);

            el.scrollIntoView({ behavior: "smooth" });
        }
    }, [])

    return <div className="container">
        <h1 className="text-center mb-30 uppercase margin-accordion">
            Питання та відповіді
        </h1>

        <div className="margin-accordion" id="delivery">
            <h1 className="text-center accordion-heading">Замовлення і доставка</h1>
            <Accordion faqList={requestAccordeon} />
        </div>

        <div className="margin-accordion" id="exchange">
            <h1 className="text-center accordion-heading">Повернення та обмін</h1>
            <Accordion faqList={exchangeAccordeon} />
        </div>

        <div className="margin-accordion" id="about">
            <h1 className="text-center accordion-heading">Про нас</h1>
            <div>
                Брендовий одяг: Ми пропонуємо великий вибір брендового одягу для чоловіків і жінок в різних стилях та напрямках моди.


                <p>Доступність: Незважаючи на брендовий характер, наш одяг доступний за доступними цінами, щоб кожен міг дозволити собі якісний одяг.</p>


                <p>Якість: Ми ретельно обираємо товари, щоб гарантувати їх високу якість та довговічність.</p>


                <p>Різноманітність стилів: В нашому асортименті є одяг різних стилів та напрямків, від класичного до кежуал і спортивного.</p>


                <p>Зручність покупок: Ми пропонуємо зручну онлайн-платформу для швидких та безпечних покупок.</p>


                <p>Висока якість обслуговування: Наша команда завжди готова надати вам індивідуальну підтримку та консультації.</p>


                <p>Доставка: Ми забезпечуємо швидку та надійну доставку вашого замовлення, щоб ви могли отримати свій одяг вчасно.</p>


                <p>Стиль та якість зараз доступні для всіх - це гасло вашого магазину, яке підкреслює вашу місію - робити брендовий одяг доступним для всіх, не компромітуючи якість.</p>
            </div>
        </div>

        <div id="contact-us">
            <h1 className="text-center accordion-heading">Зв'яжіться з нами</h1>

            <div className="body1">
                <div className="uppercase bold-label flex-row align-center">
                    <div className="standart-icon">
                        <Icons icon={'phone'} />
                    </div>

                    <div className="ml-5">
                        Контакти:
                    </div>
                </div>

                <p className="body1">
                    <span className="bold-label">ПН-ПТ:</span> 10:00 – 19:00
                </p>

                <p className="body1">
                    <span className=" bold-label">СБ-НД:</span> 10:00 - 17:00
                </p>

                <div className="flex-row align-center mb-10">
                    <div className="standart-icon">
                        <Icons icon={'telegram'} />
                    </div>

                    <div className="ml-5 bold-label">
                        @Maxm_Kos
                    </div>
                </div>

                <div className="flex-row align-center">
                    <div className="standart-icon">
                        <Icons icon={'viber'} />
                    </div>

                    <div className="ml-5 bold-label">
                        0669201260
                    </div>
                </div>
            </div>

        </div>
    </div>
}

export default QA