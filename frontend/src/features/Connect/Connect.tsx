import { useState } from "react";

type IConnectProps = {
    shopId: string
}

const Connect = ({shopId}: IConnectProps) => {
    const [botToken, setBotToken] = useState('');
    const [chatId, setChatId] = useState('');
    const [enabled, setEnabled] = useState(false);

    return (
        <div>
            <h1>Connect</h1>
            <div>
                <input type="text" value={botToken} onChange={(e) => setBotToken(e.target.value)} placeholder="botToken"/>
                <input type="text" value={chatId}  onChange={(e) => setChatId(e.target.value)}  placeholder="chatId" />
                <input type="checkbox" checked={enabled} onChange={(e) => setEnabled(e.target.checked)} />
                <button>Сохранить</button>
            </div>
        </div>
    )
}

export default Connect