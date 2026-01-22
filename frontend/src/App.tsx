import { Route, Routes } from 'react-router-dom'
import TelegramGrowthPage from './pages/TelegramGrowthPage/TelegramGrowthPage'

function App() {


  return (
    <>
      

       <Routes>
        <Route path="/" element={<h1>Главная</h1>} />
        <Route
          path="/shops/:shopId/growth/telegram"
          element={<TelegramGrowthPage/>}
        />
      </Routes>
    </>
  )
}

export default App
