import { useState } from "react";
import { usePostTelegramConnectOnServerMutation } from "./model/mutations";

type IConnectProps = {
    shopId: string
}

const Connect = ({shopId}: IConnectProps) => {

    const {mutate, isSuccess, isPending} = usePostTelegramConnectOnServerMutation(

    )
    const [botToken, setBotToken] = useState('');
    const [chatId, setChatId] = useState('');
    const [enabled, setEnabled] = useState(false);
    const handleClick = () => {
        console.log("!!!!");
        mutate({shopId, botToken, chatId, enabled});
    }

    return (
        <div>
            <h1>Соединение</h1>
            <div>
                <input type="text" value={botToken} onChange={(e) => setBotToken(e.target.value)} placeholder="botToken"/>
                <input type="text" value={chatId}  onChange={(e) => setChatId(e.target.value)}  placeholder="chatId" />
                <input type="checkbox" checked={enabled} onChange={(e) => setEnabled(e.target.checked)} />
                <button onClick={() => handleClick()}>{isPending ? 'Загрузка' : 'Соединить'}</button>
                {isSuccess && <div>Соединение добавлено</div>}
            </div>
        </div>
    )
}

export default Connect