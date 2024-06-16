export interface Reservation {
    id?: string;
    client_id: string;
    check_in_date: Date;
    check_out_date: Date;
    is_paid: boolean;
    hotel_id?: string;
    restaurant_id?: string;
    room_id?: string;
    table_id?: string;
}