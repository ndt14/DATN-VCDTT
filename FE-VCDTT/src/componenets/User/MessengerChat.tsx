declare global {
    interface Window {
      fbAsyncInit?: () => void;
      FB?: {
        init: (config: { xfbml: boolean; version: string }) => void;
      };
    }
  }
  
  // Your component
  import  { useEffect } from 'react';
  
  const MessengerChat = () => {
    useEffect(() => {
      // Initialize Facebook SDK
      window.fbAsyncInit = function() {
        window.FB?.init({
          xfbml: true,
          version: 'v18.0'
        });
      };
  
      // Load SDK asynchronously
      (function(d, s, id) {
        let js: HTMLScriptElement, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
  
        if (!fjs) return; // Check if fjs exists before accessing parentNode
  
        js = d.createElement(s) as HTMLScriptElement;
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
  
        if (fjs.parentNode) {
          fjs.parentNode.insertBefore(js, fjs);
        }
      })(document, 'script', 'facebook-jssdk');
    }, []);
  
    useEffect(() => {
      // Set attributes for Messenger Customer Chat
      const chatbot = document.getElementById('fb-customer-chat');
      chatbot?.setAttribute('page_id', '104570466083417');
      chatbot?.setAttribute('attribution', 'biz_inbox');
    }, []);
  
    return (
      <div>
        {/* Messenger Plugin chat Code */}
        <div id="fb-root"></div>
  
        {/* Your Plugin chat code */}
        <div id="fb-customer-chat" className="fb-customerchat"></div>
      </div>
    );
  };
  
  export default MessengerChat;
  