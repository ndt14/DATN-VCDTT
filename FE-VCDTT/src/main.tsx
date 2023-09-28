import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";
import "./index.css";
import ScrollToTop from "./hooks/ScrollToTop.ts";

ReactDOM.createRoot(document.getElementById("root")!).render(
  <React.StrictMode>
    {/* <ScrollToTop /> */}
    <App />
  </React.StrictMode>
);
