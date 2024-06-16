
class ValidationError extends Error {
    constructor(message: string, public errorObject: any) {
        super(message);
        this.name = "CustomError";
        this.errorObject = errorObject;
    }
}

export default ValidationError;