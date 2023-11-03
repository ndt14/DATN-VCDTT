import * as Yup from "yup";

export const loginSchema = Yup.object({
    email: Yup.string().email("Nhập đúng định dạng email").required("Email không để trống"),
    password: Yup.string().required("Mật khẩu không để trống"),
  });
  
export const registrationSchema = Yup.object({
    name: Yup.string().required("Name không để trống"),
    email: Yup.string().email("Nhập đúng định dạng email").required("Email không để trống"),
    password: Yup.string().required("Mật khẩu không để trống"),
    phone_number: Yup.string()
    .required("Số điện thoại không để trống")
    .test('valid-phone-number', 'Số điện thoại không hợp lệ', (value) => {
      const phoneRegex = /^[0-9]{10}$/; // Change the regex pattern according to your format
      return phoneRegex.test(value);
    }),
    c_password: Yup.string()
      .required("Nhập lại mật khẩu không để trống")
      .oneOf([Yup.ref("password")], "Mật khẩu sai"),
  });
  