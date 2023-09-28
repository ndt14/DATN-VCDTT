// import { BrowserRouter } from "react-router-dom";
import { BrowserRouter } from "react-router-dom";
import PublicRoutes from "./routes/PublicRoutes";
import ScrollToTop from "./hooks/ScrollToTop";

function App() {
  return (
    <>
      <BrowserRouter>
        <PublicRoutes />
      </BrowserRouter>
    </>
  );
}

export default App;
