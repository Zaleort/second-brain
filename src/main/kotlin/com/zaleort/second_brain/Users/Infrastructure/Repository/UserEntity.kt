package com.zaleort.second_brain.Users.Infrastructure.Repository

import jakarta.persistence.*
import java.util.UUID

@Entity(name = "users")
class UserEntity(
    @Id
    @GeneratedValue(strategy = GenerationType.UUID)
    val id: UUID? = null,

    @Column(name = "email")
    val email: String,

    @Column(name = "password")
    val password: String
) {
    constructor() : this(
        id = null,
        email = "",
        password = ""
    )
}