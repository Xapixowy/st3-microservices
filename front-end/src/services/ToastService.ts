import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css";

abstract class Toast {
    public message: string
    public type: string;
    public duration: number;

    constructor(message: string, type: string, duration: number) {
        this.message = message;
        this.type = type;
        this.duration = duration;
    }

    abstract show(): void;
}

class ToastSuccess extends Toast {
    constructor(message: string, duration: number) {
        super(message, 'success', duration);
    }

    show(): void {
      Toastify({
          text: this.message,
          duration: this.duration,
          newWindow: true,
          close: true,
          gravity: 'top',
          position: 'right',
          style: {
              background: '#22c55e',
              color: '#fff',
          }
      }).showToast();
    }
}

class ToastDanger extends Toast {
    constructor(message: string, duration: number) {
        super(message, 'danger', duration);
    }

    show(): void {
      Toastify({
          text: this.message,
          duration: this.duration,
          newWindow: true,
          close: true,
          gravity: 'top',
          position: 'right',
          style: {
              background: '#e74c3c',
              color: '#fff',
          }
      }).showToast();
    }
}

export default class ToastFactory {
    public static success(message: string, duration: number = 3000): void {
        new ToastSuccess(message, duration).show();
    }

    public static danger(message: string, duration: number = 3000): void {
        new ToastDanger(message, duration).show();
    }
}